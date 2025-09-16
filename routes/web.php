<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseCategoryController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\LessonRecordController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TokushohoController;
use App\Http\Controllers\VideoAdviceController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

if (app()->environment('production') || app()->environment('staging')) {
    URL::forceScheme('https');
}

Route::middleware('verified')->group(function(){
    // ロールに基づいてリダイレクト
    Route::get('/', function () {
        if (Auth::user()->role === 'super_admin') {
            return redirect()->route('super_admin.home');
        } else {
            return redirect()->route('home');
        }
    })->name('root');

    // スーパー管理者専用ルート
    Route::middleware('can:isSuperAdmin')->group(function(){
        Route::get('/super-admin/home', [SuperAdminController::class, 'index'])->name('super_admin.home');
        Route::post('/super-admin/school/update', [SuperAdminController::class, 'updateSchool'])->name('super_admin.school.update');
    });

    // 一般ユーザー用ルート
    Route::middleware('can:isNotSuperAdmin')->group(function(){
        // ホーム
        Route::get('/home', [HomeController::class, 'index'])->name('home');

        // マイページ
        Route::get('/mypage', [HomeController::class, 'mypage'])->name('mypage');
        Route::get('/password/edit', [HomeController::class, 'editPassword'])->name('password.edit');

        // スクール情報
        Route::get('/school', [SchoolController::class, 'index'])->name('school.index');

        // お問い合わせフォーム
        Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

        // 特商法ページ
        Route::get('/tokushoho', [TokushohoController::class, 'show'])->name('tokushoho.show');
    });

    // アクセス制限：管理者
    Route::middleware('can:isAdmin')->group(function(){
        // アカウント発行
        Route::get('/teacher/qrcode', [TeacherController::class, 'showQrcode'])->name('teacher.qrcode');

        // スクール情報
        Route::get('/school/edit', [SchoolController::class, 'edit'])->name('school.edit');
        Route::patch('/school/update', [SchoolController::class, 'update'])->name('school.update');
        Route::get('/school/contract', [SchoolController::class, 'contract'])->name('school.contract');

        // 講師関連
        Route::delete('/teacher/delete', [TeacherController::class, 'delete'])->name('teacher.delete');

        // 生徒関連
        Route::delete('/student/delete', [StudentController::class, 'delete'])->name('student.delete');

        // 受講プラン関連
        Route::get('/lesson_plan', [LessonPlanController::class, 'index'])->name('lesson_plan.index');
        Route::get('/lesson_plan/create', [LessonPlanController::class, 'create'])->name('lesson_plan.create');
        Route::post('/lesson_plan/store', [LessonPlanController::class, 'store'])->name('lesson_plan.store');
        Route::get('/lesson_plan/{id}', [LessonPlanController::class, 'show'])->name('lesson_plan.show');
        Route::get('/lesson_plan/{id}/edit', [LessonPlanController::class, 'edit'])->name('lesson_plan.edit');
        Route::patch('/lesson_plan/update', [LessonPlanController::class, 'update'])->name('lesson_plan.update');
        Route::delete('/lesson_plan/delete', [LessonPlanController::class, 'delete'])->name('lesson_plan.delete');

        // タグ関連
        Route::get('/tag', [TagController::class, 'index'])->name('tag.index');
        Route::get('/tag/create', [TagController::class, 'create'])->name('tag.create');
        Route::post('/tag/store', [TagController::class, 'store'])->name('tag.store');
        Route::get('/tag/{id}/edit', [TagController::class, 'edit'])->name('tag.edit');
        Route::patch('/tag/update', [TagController::class, 'update'])->name('tag.update');
        Route::delete('/tag/delete', [TagController::class, 'delete'])->name('tag.delete');

        // 講座関連
        Route::get('/course/create', [CourseController::class, 'create'])->name('course.create');
        Route::post('/course/store', [CourseController::class, 'store'])->name('course.store');
        Route::get('/course/{id}/edit', [CourseController::class, 'edit'])->name('course.edit');
        Route::patch('/course/update', [CourseController::class, 'update'])->name('course.update');
        Route::delete('/course/delete', [CourseController::class, 'delete'])->name('course.delete');
        Route::post('/course/comment/delete', [CourseController::class, 'deleteComment'])->name('course.comment.delete');
        Route::get('/course/update_order', [CourseController::class, 'updateOrderIndex'])->name('course.update_order_index');
        Route::post('/course/update_order', [CourseController::class, 'updateOrder'])->name('course.update_order');

        // 講座カテゴリ関連
        Route::get('/course_category', [CourseCategoryController::class, 'index'])->name('course_category.index');
        Route::get('/course_category/create', [CourseCategoryController::class, 'create'])->name('course_category.create');
        Route::post('/course_category/store', [CourseCategoryController::class, 'store'])->name('course_category.store');
        Route::get('/course_category/{id}/edit', [CourseCategoryController::class, 'edit'])->name('course_category.edit');
        Route::patch('/course_category/{id}', [CourseCategoryController::class, 'update'])->name('course_category.update');
        Route::delete('/course_category/{id}', [CourseCategoryController::class, 'delete'])->name('course_category.delete');
        Route::get('/course_category/update_order', [CourseCategoryController::class, 'updateOrderIndex'])->name('course_category.update_order_index');
        Route::post('/course_category/update_order', [CourseCategoryController::class, 'updateOrder'])->name('course_category.update_order');

        // 動画添削
        Route::delete('/video_advice/delete', [VideoAdviceController::class, 'delete'])->name('video_advice.delete');

        // フォーラム
        Route::get('/forum/{id}/edit', [ForumController::class, 'edit'])->name('forum.edit');
        Route::patch('/forum/update', [ForumController::class, 'update'])->name('forum.update');
        Route::delete('/forum/delete', [ForumController::class, 'delete'])->name('forum.delete');
    });

    // アクセス制限：管理者・講師
    Route::middleware('can:isTeacher')->group(function(){
        // アカウント発行
        Route::get('/student/qrcode', [StudentController::class, 'showQrcode'])->name('student.qrcode');

        // 講師関連
        Route::get('/teacher', [TeacherController::class, 'index'])->name('teacher.index');
        Route::get('/teacher/search', [TeacherController::class, 'search'])->name('teacher.search');
        Route::get('/teacher/{id}', [TeacherController::class, 'show'])->name('teacher.show');
        Route::get('/teacher/{id}/edit', [TeacherController::class, 'edit'])->name('teacher.edit');
        Route::patch('/teacher/update', [TeacherController::class, 'update'])->name('teacher.update');

        // 生徒関連
        Route::get('/student/download', [StudentController::class, 'download'])->name('student.download');
        Route::post('/student/csv', [StudentController::class, 'csv'])->name('student.csv');
        Route::get('/student', [StudentController::class, 'index'])->name('student.index');
        Route::get('/student/search', [StudentController::class, 'search'])->name('student.search');
        Route::get('/student/{id}', [StudentController::class, 'show'])->name('student.show');


        // 受講記録関連
        Route::get('/lesson_record/create', [LessonRecordController::class, 'create'])->name('lesson_record.create');
        Route::post('/lesson_record/store', [LessonRecordController::class, 'store'])->name('lesson_record.store');
        Route::get('/lesson_record/{id}/edit', [LessonRecordController::class, 'edit'])->name('lesson_record.edit');
        Route::patch('/lesson_record/update', [LessonRecordController::class, 'update'])->name('lesson_record.update');
        Route::delete('/lesson_record/delete', [LessonRecordController::class, 'delete'])->name('lesson_record.delete');

        // 動画添削関連
        Route::post('/video_advice/change_status', [VideoAdviceController::class, 'changeStatus'])->name('video_advice.change_status');
    });

    // アクセス制限：管理者・生徒
    Route::middleware('can:isAdminOrStudent')->group(function(){
        // 生徒関連
        Route::get('/student/{id}/edit', [StudentController::class, 'edit'])->name('student.edit');
        Route::patch('/student/update', [StudentController::class, 'update'])->name('student.update');
    });

    // アクセス制限：生徒
    Route::middleware('can:isStudent')->group(function(){
        // 受講記録関連
        Route::patch('/lesson_record/update_student_memo', [LessonRecordController::class, 'updateStudentMemo'])->name('lesson_record.update_student_memo');
        // 動画お気に入り
        Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');
        Route::post('/favorite/toggle', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');
    });

    Route::middleware('check_service_access')->group(function(){
        // 受講記録関連
        Route::get('/lesson_record', [LessonRecordController::class, 'index'])->name('lesson_record.index');
        Route::get('/lesson_record/search', [LessonRecordController::class, 'search'])->name('lesson_record.search');
        Route::get('/lesson_record/{id}', [LessonRecordController::class, 'show'])->name('lesson_record.show');

        // アクセス制限：生徒
        Route::middleware('can:isStudent')->group(function(){
            // 動画添削関連
            Route::get('/video_advice/create', [VideoAdviceController::class, 'create'])->name('video_advice.create');
            Route::post('/video_advice/store', [VideoAdviceController::class, 'store'])->name('video_advice.store');
            Route::get('/video_advice/{id}/edit', [VideoAdviceController::class, 'edit'])->name('video_advice.edit');
            Route::patch('/video_advice/update', [VideoAdviceController::class, 'update'])->name('video_advice.update');
        });

        // 動画添削関連
        Route::get('/video_advice', [VideoAdviceController::class, 'index'])->name('video_advice.index');
        Route::get('/video_advice/search', [VideoAdviceController::class, 'search'])->name('video_advice.search');
        Route::get('/video_advice/{id}', [VideoAdviceController::class, 'show'])->name('video_advice.show');
        Route::post('/video_advice/comment/create', [VideoAdviceController::class, 'createComment'])->name('video_advice.comment.create');
        Route::post('/video_advice/comment/delete', [VideoAdviceController::class, 'deleteComment'])->name('video_advice.comment.delete');

        // 講座関連
        Route::get('/course', [CourseController::class, 'index'])->name('course.index');
        Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.show');
        Route::post('/course/comment/create', [CourseController::class, 'createComment'])->name('course.comment.create');
        Route::post('/course/comment/{courseCommentId}/toggle-like', [CourseController::class, 'toggleCourseCommentLike']);
        Route::post('/course/update_progress', [CourseController::class, 'updateProgress'])->name('course.update_progress');

        // フォーラム関連
        Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
        Route::get('/forum/search', [ForumController::class, 'search'])->name('forum.search');
        Route::get('/forum/create', [ForumController::class, 'create'])->name('forum.create');
        Route::get('/forum/{id}', [ForumController::class, 'show'])->name('forum.show');
        Route::post('/forum/store', [ForumController::class, 'store'])->name('forum.store');
        Route::post('/forum/{id}/toggle-like', [ForumController::class, 'toggleLike'])->name('forum.toggleLike');
        Route::post('/forum/comment/create', [ForumController::class, 'createComment'])->name('forum.comment.create');
        Route::post('/forum/comment/delete', [ForumController::class, 'deleteComment'])->name('forum.comment.delete');
        Route::post('/forum/comment/{forumCommentId}/toggle-like', [ForumController::class, 'toggleForumCommentLike']);
    });

    // アクセス権限なし
    Route::get('/not_available', [ErrorController::class, 'notAvailable'])->name('not_available');
});
