<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Student;
use App\Models\StudentTeacherRelation;
use App\Models\Teacher;
use App\Models\User;
use App\Models\VideoAdvice;
use App\Models\VideoAdviceComment;
use App\Notifications\VideoAdviceCreatedNotification;
use App\Notifications\VideoAdviceCommentNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class VideoAdviceController extends Controller
{
    public function index()
    {
        // 管理者・講師の場合は全ての、生徒は自身の動画添削データを取得
        if (Auth::user()->role == 'student'){
            $videoAdviceList = VideoAdvice::getStudentPaginatedList(Auth::id());
        } else {
            $videoAdviceList = VideoAdvice::getPaginatedList(Auth::user()->school_id);
        }

        // 未読の動画添削作成・コメント通知を取得
        $unreadVideoAdviceIds = Auth::user()->unreadNotifications
                                            ->pluck('data.video_advice_id')
                                            ->unique()
                                            ->toArray();

        // 生徒リスト取得
        $students = Student::getStudents(Auth::user()->school_id);

        // 講師リスト取得
        $teachers = Teacher::getTeachers(Auth::user()->school_id);

        return view('video_advice.index', compact('videoAdviceList', 'unreadVideoAdviceIds', 'students', 'teachers'));
    }

    public function search(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'title'       => ['nullable', 'string'],
            'from'        => ['nullable', 'date'],
            'to'          => ['nullable', 'date'],
            'student_id'  => ['nullable', 'integer', 'min:1'],
            'teacher_id'  => ['nullable', 'integer', 'min:1'],
            'unread'      => ['nullable', 'in:unread'],
            'status'      => ['nullable', 'in:open'],
        ])->validate();

        // 未読の動画添削作成・コメント通知を取得
        $unreadVideoAdviceIds = Auth::user()->unreadNotifications
                                             ->pluck('data.video_advice_id')
                                             ->unique()
                                             ->toArray();

        // 管理者・講師の場合は全ての記録を、生徒の場合は自身の記録を取得
        if (Auth::user()->role == 'student'){
            $videoAdviceList = VideoAdvice::searchStudentPaginatedList(Auth::id(), $request, $unreadVideoAdviceIds);
        } else {
            $videoAdviceList = VideoAdvice::searchPaginatedList(Auth::user()->school_id, $request, $unreadVideoAdviceIds);
        }

        $students = null;
        $teachers = null;
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher'){
            // 生徒リスト取得
            $students = Student::getStudents(Auth::user()->school_id);

            // 講師リスト取得
            $teachers = Teacher::getTeachers(Auth::user()->school_id);
        }
        
        // 絞り込み条件数を取得
        $filteredCount = 0;
        foreach ($request->all() as $key => $value) {
            if ($key != 'page' && $value !== null && $value !== '') {
                $filteredCount++;
            }
        }

        return view('video_advice.index', compact('videoAdviceList', 'unreadVideoAdviceIds', 'students', 'teachers', 'filteredCount'));
    }

    public function create()
    {
        return view('video_advice.create');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'title'    => ['required', 'string', 'max:255'],
            'video'    => ['array', 'max:10'],
            'video.*'  => ['required', 'mimes:mp4,mov,3gp,av'],
            'question' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->respond([
                'result' => 'error',
                'msg'    => __('messages.error'),
                'redirect_url' => route('video_advice.create'),
            ], $request);
        }

        // 動画添削情報を登録
        $videoAdvice = VideoAdvice::createFromRequest($request);
        if ($videoAdvice === false) {
            return $this->respond([
                'result' => 'error',
                'msg'    => __('messages.error'),
                'redirect_url' => route('video_advice.create'),
            ], $request);
        }

        // メイン講師に通知更新
        $mainTeacherId = StudentTeacherRelation::getMainTeacherId($videoAdvice->student_id);
        $mainTeacher = User::find($mainTeacherId);
        $mainTeacher->notify(new VideoAdviceCreatedNotification($videoAdvice));

        // 動画保存
        $videoAdvice = $videoAdvice->uploadVideo($request->file('video'), $videoAdvice->id, Auth::user()->school_id);

        return $this->respond([
            'result' => 'success',
            'msg'    => __('messages.created_success'),
            'redirect_url' => route('video_advice.show', $videoAdvice->id)
        ], $request);
    }

    public function show(Request $request)
    {
        $videoAdvice = VideoAdvice::getVideoAdvice($request->id, Auth::user());
        if (empty($videoAdvice)){
            return redirect()->route('video_advice.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }
        $videos = explode(',', $videoAdvice->video);

        // 動画お気に入り情報を取得
        $favorites = Favorite::where('user_id', Auth::id())
                                ->where('video_category', 'video_advice')
                                ->where('video_category_id', $videoAdvice->id)
                                ->pluck('video')
                                ->toArray();

        // 未読通知を取得
        $unreadCommentIds = Auth::user()->unreadNotifications
                                        ->where('data.category', 'video_advice_comment')
                                        ->pluck('data.comment_id')
                                        ->toArray();
        
        // 通知を既読にする
        // 動画添削作成通知
        if (Auth::user()->role != 'student'){
            Auth::user()->unreadNotifications
                        ->where('data.category', 'video_advice')
                        ->where('data.video_advice_id', $request->id)
                        ->markAsRead();
        }
        // 動画添削コメント通知
        Auth::user()->unreadNotifications
                    ->where('data.category', 'video_advice_comment')
                    ->where('data.video_advice_id', $request->id)
                    ->markAsRead();

        return view('video_advice.show', compact('videoAdvice', 'videos', 'favorites', 'unreadCommentIds'));
    }

    public function edit(Request $request)
    {
        // 添削情報を取得
        $videoAdvice = VideoAdvice::getVideoAdvice($request->id, Auth::user());
        if (empty($videoAdvice)){
            return redirect()->route('video_advice.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }

        return view('video_advice.edit', compact('videoAdvice'));
    }

    public function update(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'id'       => ['required', 'integer', 'exists:video_advice,id'],
            'title'    => ['required', 'string', 'max:255'],
            'video'    => ['array', 'max:10'],
            'video.*'  => ['required', 'mimes:mp4,mov,3gp,av'],
            'question' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return $this->respond([
                'result' => 'error',
                'msg'    => __('messages.error'),
                'redirect_url' => route('video_advice.index'),
            ], $request);
        }

        // データ取得
        $videoAdvice = VideoAdvice::getVideoAdvice($request->id, Auth::user());
        if (empty($videoAdvice)){
            return $this->respond([
                'result' => 'error',
                'msg'    => __('messages.not_found'),
                'redirect_url' => route('video_advice.index'),
            ], $request);
        }

        // 生徒の場合は自分の動画かチェック
        if (!$videoAdvice->checkUserPermission(Auth::user())) {
            return $this->respond([
                'result' => 'error',
                'msg'    => __('messages.error'),
                'redirect_url' => route('video_advice.index'),
            ], $request);
        }
        
        // 動画保存
        if (!empty($request->file('video'))){
            $videoAdvice = $videoAdvice->uploadVideo($request->file('video'), $request->id, Auth::user()->school_id);
        }

        // 動画添削データを更新
        if (!$videoAdvice->updateAdvice($request)) {
            return $this->respond([
                'result' => 'error',
                'msg'    => __('messages.error'),
                'redirect_url' => route('video_advice.index'),
            ], $request);
        }
        
        return $this->respond([
            'result' => 'success',
            'msg'    => __('messages.created_success'),
            'redirect_url' => route('video_advice.show', $videoAdvice->id)
        ], $request);
    }

    public function delete(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:video_advice,id'
            ],
        ]);

        $videoAdvice = VideoAdvice::getVideoAdvice($request->id, Auth::user());
        if (empty($videoAdvice)){
            return redirect()->route('video_advice.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }
        
        $videoAdvice->delete();

        return redirect()->route('video_advice.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }

    public function changeStatus(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:video_advice,id'
            ],
            'status' => [
                'required',
                'in:open,closed'
            ]
        ]);

        $videoAdvice = VideoAdvice::getVideoAdvice($request->id, Auth::user());
        if (empty($videoAdvice)){
            return redirect()->route('video_advice.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }
        $videoAdvice->status = $request->status;
        $videoAdvice->save();

        $msg = ($request->status == 'open') ? __('messages.video_advice_opened_success') : __('messages.video_advice_closed_success');

        return redirect()->route('video_advice.show', $request->id)->with([
            'result' => 'success',
            'msg'    => $msg
        ]);
    }

    public function createComment(Request $request)
    {
        // バリデーション
        $request->validate([
            'video_advice_id'   => 'required|exists:video_advice,id',
            'parent_comment_id' => 'nullable|exists:video_advice_comments,id',
            'mentioned_user_id' => 'nullable|exists:users,id',
            'body'              => 'required'
        ]);
        
        $commentData = [
            'video_advice_id'   => $request->video_advice_id,
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
        $videoAdviceComment = VideoAdviceComment::create($commentData);

        // 自分のコメントに対するコメントではない場合は通知を登録
        if ($request->mentioned_user_id != Auth::id()){
            $commentedUser = User::find($request->mentioned_user_id);
            $commentedUser->notify(new VideoAdviceCommentNotification($request->video_advice_id, $videoAdviceComment->id));
        }

        $user = Auth::user();
        $icon = ($user->icon != null) ? '/storage/icons/' . $user->school_id . '/' . $user->icon : '/storage/img/default-icon.png';
        $mentionedUserName = (!empty($videoAdviceComment->mentionedUser->family_name)) ? $videoAdviceComment->mentionedUser->family_name . ' ' . $videoAdviceComment->mentionedUser->first_name : null;

        return new JsonResponse([
            'message' => 'Comment created successfully.',
            'comment' => $videoAdviceComment,
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
            'comment_id' => 'required|exists:video_advice_comments,id',
        ]);
        
        // コメントを削除
        VideoAdviceComment::deleteComment($request->comment_id, Auth::user()->school_id);

        return new JsonResponse([
            'message' => 'Comment deleted successfully.'
        ]);
    }

}
