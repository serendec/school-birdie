<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (auth()->user()->can('isTeacher')) {
            return $this->teacherDashboard();
        } elseif (auth()->user()->can('isStudent')) {
            return $this->studentDashboard();
        } else {
            return redirect()->route('login');
        }
    }

    public function teacherDashboard()
    {
        // 動画添削通知数
        $videoAdviceCreatedNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'video_advice')->count();
        $videoAdviceCommentNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'video_advice_comment')->count();
        $videoAdviceNotificationsCount = $videoAdviceCreatedNotificationsCount + $videoAdviceCommentNotificationsCount;

        // フォーラム通知数
        $forumCreatedNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'forum')->count();
        $forumCommentNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'forum_comment')->count();
        $forumNotificationsCount = $forumCreatedNotificationsCount + $forumCommentNotificationsCount;
        
        // 講座通知数
        $courseNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'course_comment')->count();

        return view('dashboard.index' , compact('videoAdviceNotificationsCount', 'forumNotificationsCount', 'courseNotificationsCount'));
    }

    public function studentDashboard()
    {
        $student = Student::getStudentInfoFromId(Auth::id(), Auth::user()->school_id);

        // 動画添削サービスをまだ利用していない場合で、利用可能な受講プランの場合はリコメンドを表示
        $recommendVideoAdvice = false;
        if ($student->videoAdviceList()->exists() === false && isset($student->studentProfile->lessonPlan) && $student->studentProfile->lessonPlan->video_advice_available == 1) {
            $recommendVideoAdvice = true;
        }

        // レッスン記録通知数
        $lessonRecordNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'lesson_record')->count();

        // 動画添削通知数
        $videoAdviceNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'video_advice_comment')->count();

        // フォーラム通知数
        $forumNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'forum_comment')->count();
        
        // 講座通知数
        $courseNotificationsCount = Auth::user()->unreadNotifications->where('data.category', 'course_comment')->count();
        
        return view('dashboard.index', compact('student', 'recommendVideoAdvice', 'lessonRecordNotificationsCount', 'videoAdviceNotificationsCount', 'forumNotificationsCount', 'courseNotificationsCount'));
    }

    public function mypage()
    {
        if (auth()->user()->can('isTeacher')) {
            return $this->teacherMypage();
        } elseif (auth()->user()->can('isStudent')) {
            return $this->studentMypage();
        } else {
            return redirect()->route('login');
        }
    }
    public function teacherMypage()
    {
        $teacher = Teacher::getTeacherInfoFromId(Auth::id(), Auth::user()->school_id);
        return view('mypage.teacher', compact('teacher'));
    }
    public function studentMypage()
    {
        $student = Student::getStudentInfoFromId(Auth::id(), Auth::user()->school_id);
        return view('mypage.student', compact('student'));
    }

    public function editPassword()
    {
        return view('auth.password.edit');
    }

}
