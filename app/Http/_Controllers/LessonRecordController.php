<?php

namespace App\Http\Controllers;

use App\Models\LessonRecord;
use App\Models\Student;
use App\Models\StudentTeacherRelation;
use App\Models\Tag;
use App\Models\Teacher;
use App\Models\User;
use App\Notifications\LessonRecordCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LessonRecordController extends Controller
{
    public function index()
    {
        // 管理者・講師の場合は全ての記録を、生徒の場合は自身の記録を取得
        if (Auth::user()->role == 'student'){
            $lessonRecords = LessonRecord::getStudentPaginatedList(Auth::id());
        } else {
            $lessonRecords = LessonRecord::getPaginatedList(Auth::user()->school_id);
        }
        
        // 未読の動画添削作成通知を取得
        $unreadLessonRecordIds = Auth::user()->unreadNotifications
                                            ->pluck('data.lesson_record_id')
                                            ->unique()
                                            ->toArray();

        $students = null;
        $teachers = null;
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher'){
            // 生徒リスト取得
            $students = Student::getStudents(Auth::user()->school_id);
    
            // 講師リスト取得
            $teachers = Teacher::getTeachers(Auth::user()->school_id);
        }

        // タグリスト取得
        $tags = Tag::getTags(Auth::user()->school_id);

        return view('lesson_record.index', compact('lessonRecords', 'unreadLessonRecordIds', 'students', 'teachers', 'tags'));
    }

    public function search(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'title'       => ['nullable', 'string'],
            'tag_ids'     => ['nullable', 'array'],
            'tag_ids.*'   => ['integer'],
            'from'        => ['nullable', 'date'],
            'to'          => ['nullable', 'date'],
            'student_id'  => ['nullable', 'integer', 'min:1'],
            'teacher_id'  => ['nullable', 'integer', 'min:1'],
            'post_status' => ['nullable', 'in:draft'],
            'unread'      => ['nullable', 'in:unread'],
        ])->validate();

        // init
        $unreadLessonRecordIds = [];

        // 管理者・講師の場合は全ての記録を、生徒の場合は自身の記録を取得
        if (Auth::user()->role == 'student'){
            // 未読のレッスン記録作成通知を取得
            $unreadLessonRecordIds = Auth::user()->unreadNotifications
                                                 ->pluck('data.lesson_record_id')
                                                 ->unique()
                                                 ->toArray();
            $lessonRecords = LessonRecord::searchStudentPaginatedList(Auth::id(), $request, $unreadLessonRecordIds);
        } else {
            $lessonRecords = LessonRecord::searchPaginatedList(Auth::user()->school_id, $request);
        }

        // 生徒リスト取得
        $students = Student::getStudents(Auth::user()->school_id);

        // 講師リスト取得
        $teachers = Teacher::getTeachers(Auth::user()->school_id);

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

        return view('lesson_record.index', compact('lessonRecords', 'unreadLessonRecordIds', 'students', 'teachers', 'tags', 'selectedTags', 'filteredCount'));
    }

    public function create()
    {
        // 全生徒を取得
        $studentsList = Student::getStudents(Auth::user()->school_id);

        // タグを取得
        $tags = Tag::getTags(Auth::user()->school_id);

        // キーがタグID、値がタグ名の配列を作成
        $tagsKeyId = Tag::getTagsKeyId(Auth::user()->school_id);

        return view('lesson_record.create', compact('studentsList', 'tags', 'tagsKeyId'));
    }

    public function store(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'lesson_date'     => ['required', 'date'],
            'student_id'      => ['required', 'integer', 'min:1'],
            'tag_ids'         => ['nullable', 'array'],
            'tag_ids.*'       => ['integer'],
            'title'           => ['nullable', 'string'],
            'summary'         => ['nullable', 'string'],
            'teacher_comment' => ['nullable', 'string'],
            'school_memo'     => ['nullable', 'string'],
            'post_status'     => ['required', 'in:draft,publish'],
        ])->validate();

        // レッスン記録情報を登録
        $lessonRecord = LessonRecord::createWithTags($request);
        if ($lessonRecord === false) {
            return redirect()->back()->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }

        // 下書きではない場合は生徒に通知
        if ($request->post_status == 'publish'){
            $student = User::find($request->student_id);
            $student->notify(new LessonRecordCreatedNotification($lessonRecord));
        }

        // 動画がある場合は保存
        if ($request->hasFile('video')) {
            $lessonRecord->uploadVideo($request->file('video'), $lessonRecord->id, Auth::user()->school_id);
        }

        return redirect(route('lesson_record.index'))->with([
            'result' => 'success',
            'msg'    => __('messages.created_success')
        ]);
    }

    public function show(Request $request)
    {
        $lessonRecord = LessonRecord::getLessonRecord($request->id, Auth::user()->school_id);
        if (empty($lessonRecord)){
            return redirect(route('lesson_record.index'))->with([
                'result' => 'error',
                'msg'    => __('messages.not_found')
            ]);
        }

        // 通知を既読にする
        if (Auth::user()->role == 'student'){
            $student = User::find(Auth::id());
            $student->unreadNotifications
                    ->where('data.category', 'lesson_record')
                    ->where('data.lesson_record_id', $lessonRecord->id)
                    ->markAsRead();
        }

        // 前後のレッスン記録を取得
        if (Auth::user()->role == 'student'){
            $previousLessonRecord = LessonRecord::getStudentPrevLessonRecord($lessonRecord->lesson_date, Auth::id());
            $nextLessonRecord = LessonRecord::getStudentNextLessonRecord($lessonRecord->lesson_date, Auth::id());
            $totalRecordsNumber = LessonRecord::getStudentTotalCount(Auth::id());
            $currentRecordNumber = LessonRecord::getStudentCurrentCount($lessonRecord->lesson_date, Auth::id());
        } else {
            $previousLessonRecord = LessonRecord::getPrevLessonRecord($lessonRecord->lesson_date, Auth::user()->school_id);
            $nextLessonRecord = LessonRecord::getNextLessonRecord($lessonRecord->lesson_date, Auth::user()->school_id);
            $totalRecordsNumber = LessonRecord::getTotalCount(Auth::user()->school_id);
            $currentRecordNumber = LessonRecord::getCurrentCount($lessonRecord->lesson_date, Auth::user()->school_id);
        }
        
        // 更新した場合のメッセージ
        $msg = (session('msg')) ? session('msg') : null;
        
        return view('lesson_record.show', compact('lessonRecord', 'previousLessonRecord', 'nextLessonRecord', 'totalRecordsNumber', 'currentRecordNumber', 'msg'));
    }

    public function edit(Request $request)
    {
        // 全生徒を取得
        $studentsList = Student::getStudents(Auth::user()->school_id);

        // タグを取得
        $tags = Tag::getTags(Auth::user()->school_id);
        
        // レッスン記録情報を取得
        $lessonRecord = LessonRecord::getLessonRecord($request->id, Auth::user()->school_id);
        
        // 設定されているタグ情報を配列に変換
        $lessonRecordTagIds = [];
        foreach ($lessonRecord->tags as $lessonRecordTag) {
            $lessonRecordTagIds[] = $lessonRecordTag->id;
        }

        return view('lesson_record.edit', compact('studentsList', 'tags', 'lessonRecord', 'lessonRecordTagIds'));
    }

    public function update(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'lesson_date'     => ['required', 'date'],
            'student_id'      => ['required', 'integer', 'min:1'],
            'tag_ids'         => ['nullable', 'array'],
            'tag_ids.*'       => ['integer'],
            'summary'         => ['nullable', 'string'],
            'teacher_comment' => ['nullable', 'string'],
            'school_memo'     => ['nullable', 'string'],
            'post_status'     => ['required', 'in:draft,publish'],
            'id'              => ['required', 'integer', 'exists:lesson_records,id']
        ])->validate();

        $lessonRecord = LessonRecord::find($request->id);
        $originalPostStatus = $lessonRecord->post_status;
        
        // レッスン記録情報を更新
        $lessonRecord->fill($request->except('_token', '_method', 'id', 'tag_ids'));
        $lessonRecord->save();
        $lessonRecord->tags()->sync($request->tag_ids);

        if ($lessonRecord === false) {
            return redirect()->back()->with([
                'result' => 'error',
                'msg'    => __('messages.error')
            ]);
        }

        // 下書きから公開ステータスに更新した場合は生徒に通知
        if ($originalPostStatus == 'draft' && $request->post_status == 'publish'){
            $student = User::find($request->student_id);
            $student->notify(new LessonRecordCreatedNotification($lessonRecord));
        }

        // 動画がある場合は保存
        if ($request->hasFile('video')) {
            $lessonRecord->uploadVideo($request->file('video'), $lessonRecord->id, Auth::user()->school_id);
        }

        return redirect(route('lesson_record.show', $lessonRecord->id))->with([
            'result' => 'success',
            'msg'    => __('messages.updated_success')
        ]);
    }

    public function updateStudentMemo(Request $request)
    {
        // バリデーション
        Validator::make($request->all(), [
            'lesson_record_id' => ['required', 'integer', 'exists:lesson_records,id'],
            'student_memo'     => ['nullable', 'string']
        ])->validate();

        $lessonRecord = LessonRecord::find($request->lesson_record_id);
        $lessonRecord->student_memo = $request->student_memo;
        $lessonRecord->save();

        return redirect(route('lesson_record.show', $lessonRecord->id))->with([
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
                'exists:lesson_records,id'
            ],
        ]);

        $lessonPlan = LessonRecord::getLessonRecord($request->id, Auth::user()->school_id);
        $lessonPlan->delete();

        return redirect()->route('lesson_record.index')->with([
            'result' => 'success',
            'msg'    => __('messages.deleted_success')
        ]);
    }
}
