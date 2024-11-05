<?php

namespace App\Models;

use App\Jobs\ProcessVideoJob;
use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class LessonRecord extends Model
{
    use HasFactory, BySchoolIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'teacher_id',
        'student_id',
        'content',
        'lesson_date',
        'title',
        'post_status',
        'summary',
        'teacher_comment',
        'school_memo',
        'student_memo'
    ];

    /**
     * リレーション
     *
     * @return void
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'lesson_record_tag')->withTimestamps();
    }

    /**
     * レッスン記録をタグ情報を含めて取得
     * 
     * @param int $schoolId
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function getPaginatedList(int $schoolId, int $perPage = 10): ?LengthAwarePaginator
    {
        return self::with([
                        'tags',
                        'student:id,family_name,first_name,school_id,icon',
                        'teacher:id,family_name,first_name,school_id,icon'
                    ])
                    ->whereHas('student', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->whereHas('teacher', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->select('lesson_records.id', 'lesson_records.teacher_id', 'lesson_records.student_id', 'lesson_records.title', 'lesson_records.lesson_date', 'lesson_records.post_status')
                    ->orderBy('lesson_records.lesson_date', 'desc')
                    ->paginate($perPage);
    }

    /**
     * レッスン記録をタグ情報を含めて検索
     * 
     * @param int $schoolId
     * @param Request $request
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function searchPaginatedList(int $schoolId, Request $request, int $perPage = 10): ?LengthAwarePaginator
    {
        $list = self::select('lesson_records.id', 'lesson_records.teacher_id', 'lesson_records.student_id', 'lesson_records.title', 'lesson_records.lesson_date', 'lesson_records.post_status')
                    ->with([
                        'tags',
                        'student:id,family_name,first_name,school_id,icon',
                        'teacher:id,family_name,first_name,school_id,icon'
                    ])
                    ->whereHas('student', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->whereHas('teacher', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    });
        
        // 絞り込み
        // タイトル
        if ($request->filled('title')) {
            $list->where('title', 'like', "%{$request->title}%");
        }
        // タグ
        if ($request->has('tag_ids') && !empty($request->tag_ids)) {
            $list->whereHas('tags', function ($query) use ($request) {
                foreach ($request->tag_ids as $tagId) {
                    $query->where('tags.id', $tagId);
                }
            });
        }
        // 期間
        if ($request->filled('from')) {
            $list->where('lesson_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $list->where('lesson_date', '<=', $request->to);
        }
        // 生徒
        if ($request->filled('student_id')) {
            $list->where('student_id', $request->student_id);
        }
        // 講師
        if ($request->filled('teacher_id')) {
            $list->where('teacher_id', $request->teacher_id);
        }
        // 公開状態
        if ($request->filled('post_status')) {
            $list->where('post_status', $request->post_status);
        }

        return $list->orderBy('lesson_records.lesson_date', 'desc')
                    ->paginate($perPage);
    }

    /**
     * 生徒のレッスン記録リストを取得
     *
     * @param int $studentId
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function getStudentPaginatedList(int $studentId, int $perPage = 10): ?LengthAwarePaginator
    {
        return self::with([
                        'tags',
                        'student:id,family_name,first_name,icon',
                        'teacher:id,family_name,first_name,icon'
                    ])
                    ->whereHas('student', function ($query) use ($studentId) {
                        $query->where('student_id', $studentId);
                    })
                    ->where('post_status', 'publish')
                    ->select('lesson_records.id', 'lesson_records.teacher_id', 'lesson_records.student_id', 'lesson_records.title', 'lesson_records.lesson_date', 'lesson_records.post_status')
                    ->orderBy('lesson_records.lesson_date', 'desc')
                    ->paginate($perPage);
    }

    /**
     * 生徒のレッスン記録リストを検索
     *
     * @param int $studentId
     * @param Request $request
     * @param array $unreadLessonRecordIds
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function searchStudentPaginatedList(int $studentId, Request $request, array $unreadLessonRecordIds = [], int $perPage = 10): ?LengthAwarePaginator
    {
        $list = self::select('lesson_records.id', 'lesson_records.teacher_id', 'lesson_records.student_id', 'lesson_records.title', 'lesson_records.lesson_date', 'lesson_records.post_status')
                    ->with([
                        'tags',
                        'student:id,family_name,first_name,icon',
                        'teacher:id,family_name,first_name,icon'
                    ])
                    ->whereHas('student', function ($query) use ($studentId) {
                        $query->where('student_id', $studentId);
                    })
                    ->where('post_status', 'publish');

        // 絞り込み
        // タイトル
        if ($request->filled('title')) {
            $list->where('title', 'like', "%{$request->title}%");
        }
        // タグ
        if ($request->has('tag_ids') && !empty($request->tag_ids)) {
            $list->whereHas('tags', function ($query) use ($request) {
                foreach ($request->tag_ids as $tagId) {
                    $query->where('tags.id', $tagId);
                }
            });
        }
        // 期間
        if ($request->filled('from')) {
            $list->where('lesson_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $list->where('lesson_date', '<=', $request->to);
        }
        // 未読通知がある
        if ($request->filled('unread')) {
            $list->whereIn('id', $unreadLessonRecordIds);
        }

        return $list->orderBy('lesson_records.lesson_date', 'desc')
                    ->paginate($perPage);
    }

    /**
     * レッスン記録の詳細を取得
     *
     * @param int $lessonRecordId
     * @param int $schoolId
     * @return LessonRecord|null
     */
    public static function getLessonRecord(int $lessonRecordId, int $schoolId): ?self
    {
        return self::with([
                        'tags',
                        'student:id,family_name,first_name,school_id,icon',
                        'teacher:id,family_name,first_name,school_id,icon'
                    ])
                    ->whereHas('student', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->whereHas('teacher', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->where('lesson_records.id', $lessonRecordId)
                    ->first();
    }

    /**
     * 一つ前のレッスン記録を取得
     *
     * @param string $lessonDate
     * @param int $schoolId
     * @return self|null
     */
    public static function getPrevLessonRecord(string $lessonDate, int $schoolId) : ?self
    {
        return self::whereHas('teacher', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->where('lesson_date', '>', $lessonDate)
                    ->orderBy('lesson_date')
                    ->first();
    }

    /**
     * 一つ後のレッスン記録を取得
     *
     * @param string $lessonDate
     * @param int $schoolId
     * @return self|null
     */
    public static function getNextLessonRecord(string $lessonDate, int $schoolId) : ?self
    {
        return self::whereHas('teacher', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->where('lesson_date', '<', $lessonDate)
                    ->orderBy('lesson_date', 'desc')
                    ->first();
    }

    /**
     * 指定した生徒の、特定の記録の一つ前のレッスン記録を取得
     *
     * @param string $lessonDate
     * @param int $studentId
     * @return self|null
     */
    public static function getStudentPrevLessonRecord(string $lessonDate, int $studentId) : ?self
    {
        return self::where('student_id', $studentId)
                    ->where('lesson_date', '>', $lessonDate)
                    ->where('post_status', 'publish')
                    ->orderBy('lesson_date', 'desc')
                    ->first();
    }

    /**
     * 指定した生徒の、特定の記録の一つ後のレッスン記録を取得
     *
     * @param string $lessonDate
     * @param int $studentId
     * @return self|null
     */
    public static function getStudentNextLessonRecord(string $lessonDate, int $studentId) : ?self
    {
        return self::where('student_id', $studentId)
                    ->where('lesson_date', '<', $lessonDate)
                    ->where('post_status', 'publish')
                    ->orderBy('lesson_date', 'desc')
                    ->first();
    }

    /**
     * スクールのレッスン記録の総数を取得
     *
     * @param int $schoolId
     * @return int
     */
    public static function getTotalCount(int $schoolId) : int 
    {
        return self::whereHas('teacher', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->count();
    }

    /**
     * スクールのレッスン記録の現在の順番を取得
     *
     * @param string $lessonDate
     * @param int $schoolId
     * @return int
     */
    public static function getCurrentCount(string $lessonDate, int $schoolId) : int
    {
        return self::whereHas('teacher', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->where('lesson_date', '>=', $lessonDate)
                    ->orderby('lesson_date', 'desc')
                    ->count();
    }

    /**
     * 生徒のレッスン記録の総数を取得
     *
     * @param int $studentId
     * @return int
     */
    public static function getStudentTotalCount(int $studentId) : int 
    {
        return self::where('student_id', $studentId)
                    ->where('post_status', 'publish')
                    ->count();
    }

    /**
     * 生徒のレッスン記録の現在の順番を取得
     *
     * @param string $lessonDate
     * @param int $studentId
     * @return int
     */
    public static function getStudentCurrentCount(string $lessonDate, int $studentId) : int
    {
        return self::where('student_id', $studentId)
                    ->where('lesson_date', '>=', $lessonDate)
                    ->where('post_status', 'publish')
                    ->orderby('lesson_date', 'desc')
                    ->count();
    }

    /**
     * レッスン記録の登録
     *
     * @param Request $request
     * @return LessonRecord
     */
    public static function createWithTags(Request $request): LessonRecord
    {
        $lessonRecord = new self([
            'teacher_id'      => $request->teacher_id,
            'student_id'      => $request->student_id,
            'lesson_date'     => $request->lesson_date,
            'title'           => $request->title,
            'summary'         => $request->summary,
            'teacher_comment' => $request->teacher_comment,
            'school_memo'     => $request->school_memo,
            'post_status'     => $request->post_status
        ]);
        $lessonRecord->save();

        if (!empty($request->tag_ids)) {
            $lessonRecord->tags()->attach($request->tag_ids);
        }

        return $lessonRecord;
    }

    /**
     * 動画アップロード、キュー追加、DB内動画名更新
     *
     * @param Array $videoFiles
     * @param int $id LessonRecordインスタンスのID
     * @param int $schoolId
     * @return self
     */
    public function uploadVideo(Array $videoFiles, int $id, int $schoolId): ?self
    {
        // 既存の動画ファイルを削除
        $videoDirectoryPath = 'media/lesson_record/'.$schoolId.'/'.$id;
        Storage::disk('public')->deleteDirectory($videoDirectoryPath);

        $videoBasename = '';
        foreach ($videoFiles as $videoFile) {
            $videoFilePath = $videoFile->store($videoDirectoryPath, 'local');

            // 動画のエンコード処理を非同期で実行
            ProcessVideoJob::dispatch($videoFilePath, $videoDirectoryPath);

            $videoBasename = ($videoBasename == '') ? basename($videoFilePath) : $videoBasename.','.basename($videoFilePath);
        }

        // DB情報更新
        $this->video = $videoBasename;
        $this->save();

        return $this;
    }
}
