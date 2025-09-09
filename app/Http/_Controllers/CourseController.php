<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CourseComment;
use App\Models\StudentTeacherRelation;
use App\Models\User;
use App\Models\UserCourseProgress;
use App\Notifications\CourseCommentNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        // カテゴリ毎の講座一覧を取得
        $categories = CourseCategory::getAllCoursesGroupedByCategory(Auth::user()->school_id, Auth::user()->role);
        
        // 完了した講座IDを取得
        $completedCourseIds = Auth::user()->UserCourseProgress()->pluck('course_id')->toArray();

        // 未読の講座コメント通知を取得
        $unreadCourseIds = Auth::user()->unreadNotifications
                                       ->pluck('data.course_id')
                                       ->unique()
                                       ->toArray();
        
        return view('course.index', compact('categories', 'completedCourseIds', 'unreadCourseIds'));
    }

    public function create()
    {
        $categories = CourseCategory::getAllCategories(Auth::user()->school_id);
        return view('course.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $school_id = Auth::user()->school_id;

        // validation
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'category_id' => [
                'required',
                'exists:course_categories,id',
                Rule::exists('course_categories', 'id')->where('school_id', $school_id),
            ],
            'video' => 'nullable',
            'content' => 'nullable',
        ]);
        $validator->setAttributeNames([
            'title' => '講座名',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $category_id = $request->input('category_id');
        $display_order = Course::where('category_id', $category_id)->count() + 1;

        // save
        $course = new Course($request->only(['title', 'video', 'content', 'category_id']));
        $course->school_id = $school_id;
        $course->display_order = $display_order;
        $course->post_status = $request->input('post_status', 'draft');
        $course->save();

        // 動画がある場合は保存
        if ($request->hasFile('video')) {
            $course->uploadVideo($request->file('video'), $course->id, Auth::user()->school_id);
        }

        $msg = ($course->post_status == 'draft') ? __('messages.course_created_draft_success') : __('messages.course_created_success');
        return redirect()->route('course.index')->with([
            'result' => 'success',
            'msg'    => $msg
        ]);
    }

    public function show(Request $request)
    {
        $course = Course::getContentWithComments($request->id, Auth::user()->school_id);
        if (empty($course)){
            return redirect()->route('course.index')->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }

        // 未読通知を取得
        $unreadCommentIds = Auth::user()->unreadNotifications
                                        ->where('data.category', 'course_comment')
                                        ->pluck('data.comment_id')
                                        ->toArray();
        
        // コメント通知を既読にする
        Auth::user()->unreadNotifications
            ->where('data.category', 'course_comment')
            ->where('data.course_id', $request->id)
            ->markAsRead();

        // 完了ステータスを取得
        $isCompleted = UserCourseProgress::getIsCompletedValue($course->id, Auth::id());
        
        // いいねしたコメントのIDを取得
        $likedCommentIds = Auth::user()->courseCommentLikes()->pluck('course_comment_id');
        
        return view('course.show', compact('course', 'isCompleted', 'likedCommentIds', 'unreadCommentIds'));
    }

    public function edit(Request $request)
    {
        $course = Course::getContent($request->id, Auth::user()->school_id);
        $categories = CourseCategory::getAllCategories(Auth::user()->school_id);
        return view('course.edit', compact('course', 'categories'));
    }

    public function update(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:courses,id',
                Rule::exists('courses', 'id')->where('school_id', Auth::user()->school_id),
            ],
            'title' => 'required',
            'category_id' => [
                'required',
                'exists:course_categories,id',
                Rule::exists('course_categories', 'id')->where('school_id', Auth::user()->school_id),
            ],
            'video' => 'nullable',
            'content' => 'nullable',
        ]);

        $course = Course::find($request->id);
        $course->title = $request->title;
        $course->category_id = $request->category_id;
        $course->content = $request->content;
        $course->post_status = $request->post_status;
        $course->save();

        // 動画がある場合は保存
        if ($request->hasFile('video')) {
            $course->uploadVideo($request->file('video'), $course->id, Auth::user()->school_id);
        }
        
        return redirect()->route('course.show', ['id' => $request->id])->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }

    public function updateProgress(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:courses,id',
                Rule::exists('courses', 'id')->where('school_id', Auth::user()->school_id),
            ],
            'is_completed' => ['required', 'boolean']
        ]);

        $course = UserCourseProgress::updateIsCompleted($request, Auth::id());
        if (!$course){
            return redirect()->route('course.show', ['id' => $request->id])->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }
        
        return redirect()->route('course.show', ['id' => $request->id])->with([
            'result' => 'success',
            'msg'    => __('messages.course_update_progress_success')
        ]);
    }

    public function delete(Request $request)
    {
        // validate
        $request->validate([
            'id' => [
                'required',
                'exists:courses,id',
                Rule::exists('courses', 'id')->where('school_id', Auth::user()->school_id),
            ],
        ]);

        $course = Course::find($request->id);
        $course->delete();

        return redirect()->route('course.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }

    public function createComment(Request $request)
    {
        // バリデーション
        $request->validate([
            'course_id'         => 'required|exists:courses,id',
            'parent_comment_id' => 'nullable|exists:course_comments,id',
            'mentioned_user_id' => 'nullable|exists:users,id',
            'body'              => 'required'
        ]);
        
        // コメントを登録
        $courseComment = CourseComment::create([
            'course_id'         => $request->course_id,
            'parent_comment_id' => $request->parent_comment_id,
            'mentioned_user_id' => $request->mentioned_user_id,
            'user_id'           => Auth::id(),
            'body'              => $request->body
        ]);

        // 自分のコメントに対するコメントではない場合は通知を登録
        if ($request->mentioned_user_id != Auth::id()){
            $mentioned_user_id = $request->mentioned_user_id;
            // 講座自体に対する生徒のコメントの場合はメイン講師に通知
            if (empty($mentioned_user_id) && Auth::user()->role == 'student'){
                $mentioned_user_id = StudentTeacherRelation::getMainTeacherId(Auth::id());
            }
            if (!empty($mentioned_user_id)){
                $commentedUser = User::find($mentioned_user_id);
                $commentedUser->notify(new CourseCommentNotification($request->course_id, $courseComment->id));
            }
        }

        $user = Auth::user();
        $icon = ($user->icon != null) ? '/storage/icons/' . $user->school_id . '/' . $user->icon : '/storage/img/default-icon.png';
        $mentionedUserName = (!empty($courseComment->mentionedUser->family_name)) ? $courseComment->mentionedUser->family_name . ' ' . $courseComment->mentionedUser->first_name : null;

        return new JsonResponse([
            'message' => 'Comment created successfully.',
            'comment' => $courseComment,
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
            'comment_id' => 'required|exists:course_comments,id',
        ]);
        
        // コメントを削除
        CourseComment::deleteComment($request->comment_id, Auth::user()->school_id);

        return new JsonResponse([
            'message' => 'Comment deleted successfully.'
        ]);
    }

    public function updateOrderIndex()
    {
        // カテゴリ毎の講座一覧を取得
        $categories = CourseCategory::getAllCoursesGroupedByCategory(Auth::user()->school_id, Auth::user()->role);
        
        return view('course.update_order', compact('categories'));
    }    

    public function updateOrder(Request $request)
    {
        // バリデーション
        $school_id = Auth::user()->school_id;
        $request->validate([
            'categoryId' => 'required|exists:course_categories,id',
            'courseIds.*' => [
                'required',
                'integer',
                'exists:courses,id',
                Rule::exists('courses', 'id')
                    ->where('school_id', $school_id)
                    ->where('category_id', $request->categoryId)
            ]
        ]);

        // コースの表示順を更新
        Course::updateOrder($request->courseIds);

        return new JsonResponse([
            'message' => 'Order updated successfully.'
        ]);

    }

    public function toggleCourseCommentLike(Request $request, $courseCommentId)
    {
        $user = $request->user();
        $courseComment = CourseComment::findOrFail($courseCommentId);

        if ($user->hasLikedCourseComment($courseCommentId)) {
            $user->courseCommentLikes()->where('course_comment_id', $courseCommentId)->delete();
        } else {
            $courseComment->likes()->create(['user_id' => $user->id]);
        }

        return response()->json(['success' => true]);
    }
}
