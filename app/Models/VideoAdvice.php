<?php

namespace App\Models;

use App\Jobs\ProcessVideoJob;
use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VideoAdvice extends Model
{
    use HasFactory, BySchoolIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'title',
        'video',
        'question',
        'status'
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
    public function comments()
    {
        return $this->hasMany(VideoAdviceComment::class)->orderBy('created_at', 'desc');
    }

    /**
     * スクールの全ての動画添削データを取得
     * 
     * @param int $schoolId
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function getPaginatedList(int $schoolId, int $perPage = 10): ?LengthAwarePaginator
    {
        return self::with(['student:id,family_name,first_name,school_id,icon', 'student.teachers:id,family_name,first_name,student_teacher_relations.category,icon'])
                    ->whereHas('student', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->orderby('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * スクールの動画添削データを検索
     * 
     * @param int $schoolId
     * @param Request $request
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function searchPaginatedList(int $schoolId, Request $request, array $unreadLessonRecordIds = [], int $perPage = 10): ?LengthAwarePaginator
    {
        $list = self::with(['student:id,family_name,first_name,school_id,icon', 'student.teachers:id,family_name,first_name,student_teacher_relations.category,icon'])
                    ->whereHas('student', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    });

        // 絞り込み
        // タイトル
        if ($request->filled('title')) {
            $list->where('title', 'like', "%{$request->title}%");
        }
        // 期間
        if ($request->filled('from')) {
            $list->where('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $list->where('created_at', '<=', $request->to);
        }
        // 生徒
        if ($request->filled('student_id')) {
            $list->where('student_id', $request->student_id);
        }
        // 講師
        if ($request->filled('teacher_id')) {
            $list->whereHas('student', function ($query) use ($request) {
                $query->whereHas('teachers', function ($query) use ($request) {
                    $query->where('teacher_id', $request->teacher_id)
                          ->where('student_teacher_relations.category', 'main');
                });
            });
        }
        // 未完了
        if ($request->filled('status')) {
            $list->where('status', 'open');
        }
        // 未読通知がある
        if ($request->filled('unread')) {
            $list->whereIn('id', $unreadLessonRecordIds);
        }

        return $list->orderby('created_at', 'desc')
                    ->paginate($perPage);
    }    

    /**
     * 生徒の動画添削データを取得
     *
     * @param int $studentId
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function getStudentPaginatedList(int $studentId, int $perPage = 10): ?LengthAwarePaginator
    {
        return self::with([
                        'student:id,family_name,first_name,school_id,icon',
                        'student.teachers:id,family_name,first_name,student_teacher_relations.category,icon'
                    ])
                    ->whereHas('student', function ($query) use ($studentId) {
                        $query->where('student_id', $studentId);
                    })
                    ->orderby('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * 生徒の動画添削データを検索
     *
     * @param int $studentId
     * @param Request $request
     * @param array<int> $unreadLessonRecordIds
     * @param int $perPage
     * 
     * @return Illuminate\Pagination\LengthAwarePaginator|null
     */
    public static function searchStudentPaginatedList(int $studentId, Request $request, array $unreadLessonRecordIds = [], int $perPage = 10): ?LengthAwarePaginator
    {
        $list = self::with([
                        'student:id,family_name,first_name,school_id,icon',
                        'student.teachers:id,family_name,first_name,student_teacher_relations.category,icon'
                    ])
                    ->whereHas('student', function ($query) use ($studentId) {
                        $query->where('student_id', $studentId);
                    });

        // 絞り込み
        // タイトル
        if ($request->filled('title')) {
            $list->where('title', 'like', "%{$request->title}%");
        }
        // 期間
        if ($request->filled('from')) {
            $list->where('created_at', '>=', $request->from.' 00:00:00');
        }
        if ($request->filled('to')) {
            $list->where('created_at', '<=', $request->to.' 23:59:59');
        }
        // 未読通知がある
        if ($request->filled('unread')) {
            $list->whereIn('id', $unreadLessonRecordIds);
        }
        
        return $list->orderby('created_at', 'desc')
                    ->paginate($perPage);
    }

    /**
     * 動画添削データを取得
     *
     * @param int $id
     * @param User $user
     * @return videoAdvice|null
     */
    public static function getVideoAdvice(int $id, User $user): ?videoAdvice
    {
        $schoolId = $user->school_id;
        $videoAdvice = self::with([
                        'student:id,family_name,first_name,school_id',
                        'student.teachers:id,family_name,first_name,student_teacher_relations.category,icon',
                        'comments' => function ($query){
                            $query->orderBy('created_at', 'asc');
                        }
                    ])
                    ->whereHas('student', function ($query) use ($schoolId) {
                        $query->bySchoolId($schoolId);
                    })
                    ->find($id);
        
        if ($user->role == 'student' && $videoAdvice->student_id != $user->id) {
            return null;
        }

        return $videoAdvice;
    }

    /**
     * 動画添削情報を保存
     * 
     * @param Request $request
     * @return videoAdvice|false
     */
    public static function createFromRequest(Request $request): videoAdvice|false
    {
        return self::create([
            'student_id' => Auth::user()->id,
            'title'      => $request->title,
            'video'      => null,
            'question'   => $request->question
        ]);
    }

    /**
     * 動画添削情報更新
     *
     * @param Request $request
     * @return bool
     */
    public function updateAdvice(Request $request): bool
    {
        $this->title = $request->title;
        $this->question = $request->question;

        return $this->save();
    }

    /**
     * 動画アップロード、キュー追加、DB内動画名更新
     *
     * @param Array $videoFiles
     * @param int $id VideoAdviceインスタンスのID
     * @param int $schoolId
     * @return self
     */
    public function uploadVideo(Array $videoFiles, int $id, int $schoolId): ?self
    {
        // 既存の動画ファイルを削除
        $videoDirectoryPath = 'media/video_advice/'.$schoolId.'/'.$id;
        Storage::disk('public')->deleteDirectory($videoDirectoryPath);

        $videoBasename = '';
        foreach ($videoFiles as $videoFile) {
            // 動画ファイルを保存
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

    /**
     * VideoAdviceへのアクセス制限
     *
     * @param User $user
     * @return bool
     */
    public function checkUserPermission(User $user): bool
    {
        if ($user->role == 'student' && $this->student_id != $user->id) {
            return false;
        }

        return true;
    }

}
