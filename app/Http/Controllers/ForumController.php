<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\ForumLike;
use App\Models\Student;
use App\Models\StudentTeacherRelation;
use App\Models\Tag;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\ForumCreatedNotification;
use App\Notifications\ForumCommentNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    public function index()
    {
        // 一覧を取得
        $forums = Forum::getPaginatedList(Auth::user()->school_id);
        
        // 未読の動画添削作成通知を取得
        $unreadForumIds = Auth::user()->unreadNotifications
                                      ->pluck('data.forum_id')
                                      ->unique()
                                      ->toArray();

        // スクールのユーザーを取得
        $users = null;
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher'){
            $users = User::getSchoolUsers(Auth::user()->school_id);
        }

        // タグリスト取得
        $tags = Tag::getTags(Auth::user()->school_id);

        // タグのランキング取得
        $rankedTags = Tag::getTagRanking(Auth::user()->school_id);

        return view('forum.index', compact('forums', 'unreadForumIds', 'users', 'tags', 'rankedTags'));
    }

    public function search(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'title'     => ['nullable', 'string'],
            'tag_ids'   => ['nullable', 'array'],
            'tag_ids.*' => ['integer'],
            'from'      => ['nullable', 'date'],
            'to'        => ['nullable', 'date'],
            'user_id'   => ['nullable', 'integer', 'min:1'],
            'unread'    => ['nullable', 'in:unread'],
        ])->validate();

        // 未読のフォーラム作成・コメント通知を取得
        $unreadForumIds = Auth::user()->unreadNotifications
                                        ->pluck('data.forum_id')
                                        ->unique()
                                        ->toArray();
        $forums = Forum::searchPaginatedList(Auth::user()->school_id, $request, $unreadForumIds);

        // ユーザーリスト取得
        $users = User::getSchoolUsers(Auth::user()->school_id);

        // タグリスト取得
        $tags = Tag::getTags(Auth::user()->school_id);
        // 選択されたタグリストを取得
        $selectedTags = [];
        if (!empty($request->tag_ids)){
            $selectedTags = Tag::whereIn('id', $request->tag_ids)->get();
        }

        // 絞り込み条件数を取得
        $filteredCount = 0;
        foreach ($request->all() as $key => $value) {
            if ($key != 'page' && $value !== null && $value !== '') {
                $filteredCount++;
            }
        }

        // タグのランキング取得
        $rankedTags = Tag::getTagRanking(Auth::user()->school_id);

        return view('forum.index', compact('forums', 'unreadForumIds', 'users', 'tags', 'selectedTags', 'filteredCount', 'rankedTags'));
    }    

    public function create()
    {
        // タグを取得
        $tags = Tag::getTags(Auth::user()->school_id);
        return view('forum.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        // レッスン記録情報を登録
        $forum = Forum::createWithTags($request, Auth::user());
        if ($forum === false) {
            return redirect()->back()->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }

        // 生徒が作成した場合は、メイン講師に通知更新
        if (Auth::user()->role == 'student'){
            $mainTeacherId = StudentTeacherRelation::getMainTeacherId(Auth::id());
            $mainTeacher = User::find($mainTeacherId);
            $mainTeacher->notify(new ForumCreatedNotification($forum));
        }

        // 画像の保存
        $this->saveImages($request, $forum);

        return redirect()->route('forum.show', $forum->id)->with([
            'result' => 'success',
            'msg'    => __('messages.created_success')
        ]);
    }

    public function show(Request $request)
    {
        $user = Auth::user();

        // トピックを取得
        $forum = Forum::getContentWithComments($request->id, $user->school_id);
        if (empty($forum)){
            return redirect()->route('forum.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }
        // 画像pathの処理
        $forum->imagePaths = Helper::getImagesPathsArray($forum, 'forum', $user->school_id);

        // 未読通知を取得
        $unreadCommentIds = Auth::user()->unreadNotifications
                                        ->where('data.category', 'forum_comment')
                                        ->pluck('data.comment_id')
                                        ->toArray();
        
        // 通知を既読にする
        // トピック作成通知
        if (Auth::user()->role != 'student'){
            Auth::user()->unreadNotifications
                        ->where('data.category', 'forum')
                        ->where('data.forum_id', $request->id)
                        ->markAsRead();
        }
        // コメント通知
        Auth::user()->unreadNotifications
            ->where('data.category', 'forum_comment')
            ->where('data.forum_id', $request->id)
            ->markAsRead();
        
        // いいねしたトピック・コメントのIDを取得
        $likedForum = ForumLike::checkLiked($user->id, $forum->id);
        $likedCommentIds = $user->forumCommentLikes()->pluck('forum_comment_id');

        return view('forum.show', compact('forum', 'likedForum', 'likedCommentIds', 'unreadCommentIds'));
    }

    public function edit(Request $request)
    {
        // 添削情報を取得
        $forum = Forum::getContent($request->id, Auth::user()->school_id);

        // タグを取得
        $tags = Tag::getTags(Auth::user()->school_id);

        // 設定されているタグ情報を配列に変換
        $forumSetTags = [];
        foreach ($forum->tags as $tag) {
            $forumSetTags[] = $tag;
        }

        return view('forum.edit', compact('forum', 'tags', 'forumSetTags'));
    }

    public function update(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'title'   => 'required|string|max:255',
            'content' => 'required',
            'id'      => 'required|integer|exists:forums,id'
        ])->validate();

        // トピックを更新
        $forum = Forum::updateWithTags($request);
        if ($forum === false) {
            return redirect()->back()->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }

        // 画像の保存
        $this->saveImages($request, $forum);

        return redirect(route('forum.show', $forum->id))->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }

    public function delete(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:forums,id'
            ],
        ]);

        $lessonPlan = Forum::getContent($request->id, Auth::user()->school_id);
        $lessonPlan->delete();

        return redirect()->route('forum.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }

    private function saveImages($request, $forum)
    {
        if ($request->hasFile('images')) {
            $savePath = 'media/forum/' . Auth::user()->school_id . '/' . $forum->id;
            $files = $request->file('images');
            $fileNames = '';
            
            // Check if directory exists and is not empty
            if (Storage::disk('public')->exists($savePath) && $filesInDirectory = Storage::disk('public')->files($savePath)) {
                Storage::disk('public')->delete($filesInDirectory);
            }

            foreach ($files as $file) {
                $fileName = $file->store($savePath, 'public');
                $fileNames .= ($fileNames == '') ? basename($fileName) : ',' . basename($fileName);
            }
            $forum->images = $fileNames;
            $forum->save();
        }
    }

    public function createComment(Request $request)
    {
        // バリデーション
        $request->validate([
            'forum_id'          => 'required|exists:forums,id',
            'parent_comment_id' => 'nullable|exists:forum_comments,id',
            'mentioned_user_id' => 'exists:users,id',
            'body'              => 'required'
        ]);
        
        $commentData = [
            'forum_id'          => $request->forum_id,
            'parent_comment_id' => $request->parent_comment_id,
            'mentioned_user_id' => null,
            'user_id'           => Auth::id(),
            'body'              => $request->body,
        ];
        // メンションされたユーザーのIDを設定
        if ($request->mentioned_user_id != Auth::id()){
            $commentData['mentioned_user_id'] = $request->mentioned_user_id;
        }

        // コメントを登録
        $forumComment = ForumComment::create($commentData);

        // 自分のコメントに対するコメントではない場合は通知を登録
        if ($request->mentioned_user_id != Auth::id()){
            $commentedUser = User::find($request->mentioned_user_id);
            $commentedUser->notify(new ForumCommentNotification($request->forum_id, $forumComment->id));
        }

        $user = Auth::user();
        $icon = ($user->icon != null) ? '/storage/icons/' . $user->school_id . '/' . $user->icon : '/storage/img/default-icon.png';
        $mentionedUserName = (!empty($forumComment->mentionedUser->family_name)) ? $forumComment->mentionedUser->family_name . ' ' . $forumComment->mentionedUser->first_name : null;

        return new JsonResponse([
            'message' => 'Comment created successfully.',
            'comment' => $forumComment,
            'user'    => [
                'commentUserName'   => $user->family_name . ' ' . $user->first_name,
                'mentionedUserName' => $mentionedUserName,
                'icon'              => $icon,
                'role'              => $user->role
            ]
        ]);
    }

    public function deleteComment(Request $request)
    {
        // バリデーション
        $request->validate([
            'comment_id' => 'required|exists:forum_comments,id',
        ]);
        
        // コメントを削除
        ForumComment::deleteComment($request->comment_id, Auth::user()->school_id);

        return new JsonResponse([
            'message' => 'Comment deleted successfully.'
        ]);
    }

    public function toggleLike(Request $request)
    {
        $user = Auth::user();
        $forum = Forum::findOrFail($request->id);
        $like = $user->forumLikes()->where('forum_id', $forum->id)->first();

        if ($like) {
            $like->delete();
            return response()->json(['message' => 'Forum topic unliked', 'liked' => false]);
        } else {
            $user->forumLikes()->create([
                'forum_id' => $forum->id
            ]);
            return response()->json(['message' => 'Forum topic liked', 'liked' => true]);
        }
    }

    public function toggleForumCommentLike(Request $request, $forumCommentId)
    {
        $user = $request->user();
        $forumComment = ForumComment::findOrFail($forumCommentId);

        if ($user->hasLikedForumComment($forumCommentId)) {
            $user->forumCommentLikes()->where('forum_comment_id', $forumCommentId)->delete();
        } else {
            $forumComment->likes()->create(['user_id' => $user->id]);
        }

        return response()->json(['success' => true]);
    }
    
}
