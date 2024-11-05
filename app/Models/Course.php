<?php

namespace App\Models;

use App\Jobs\ProcessVideoJob;
use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use HasFactory, BySchoolIdTrait;

    protected $fillable = [
        'title', 'video', 'video_duration', 'content', 'category_id', 'school_id', 'post_status', 'display_order'
    ];

    /**
     * リレーション
     *
     * @return void
     */
    public function category()
    {
        return $this->belongsTo(CourseCategory::class);
    }
    public function school()
    {
        return $this->belongsTo(School::class);
    }
    public function comments()
    {
        return $this->hasMany(CourseComment::class)->orderBy('created_at', 'desc');
    }

    /**
     * 講座を取得
     *
     * @param int $id
     * @param int $school_id
     * @return Course|null
     */
    public static function getContent(int $id, int $school_id): ?Course
    {
        return self::BySchoolId($school_id)->findOrFail($id);
    }

    /**
     * 講座をコメント情報と共に取得
     *
     * @param int $id
     * @param int $school_id
     * @return Course|null
     */
    public static function getContentWithComments(int $id, int $school_id): ?Course
    {
        return self::with([
            'comments' => function ($query) {
                $query->withCount('likes');
            },
            'comments.children' => function ($query) {
                $query->withCount('likes');
            }
        ])
        ->BySchoolId($school_id)
        ->findOrFail($id);
    }

    /**
     * 講座表示順を更新
     *
     * @param array $courseIds
     * @return void
     */
    public static function updateOrder(array $courseIds)
    {
        foreach ($courseIds as $index => $courseId) {
            $course = self::findOrFail($courseId);
            $course->display_order = $index + 1;
            $course->save();
        }
    }

    /**
     * 動画アップロード、キュー追加、DB内動画名更新
     *
     * @param UploadedFile $videoFile
     * @param int $id courseインスタンスのID
     * @param int $schoolId
     * @return self
     */
    public function uploadVideo(UploadedFile $videoFile, int $id, int $schoolId): ?self
    {
        $videoDirectoryPath = 'media/course/'.$schoolId.'/'.$id;
        $videoFilePath = $videoFile->store($videoDirectoryPath, 'local');

        // 既存の動画ファイルを削除
        Storage::disk('public')->deleteDirectory($videoDirectoryPath);
        
        // 動画のエンコード処理を非同期で実行
        ProcessVideoJob::dispatch($videoFilePath, $videoDirectoryPath);

        // DB情報更新
        $this->video = basename($videoFilePath);
        $this->save();

        return $this;
    }
}
