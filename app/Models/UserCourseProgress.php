<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class UserCourseProgress extends Model
{
    use HasFactory, BySchoolIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'first_played_at',
        'is_watched',
        'is_completed',
        'last_played_at',
        'played_count'
    ];

    /**
     * Get the user that owns the data
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getIsCompletedValue(int $courseId, int $userID)
    {
        return self::where('user_id', $userID)
                    ->where('course_id', $courseId)
                    ->value('is_completed');
    }

    public static function getIsWatchedValue(int $courseId, int $userID)
    {
        return self::where('user_id', $userID)
            ->where('course_id', $courseId)
            ->value('is_watched');
    }

    /**
     * 完了ステータスの更新
     *
     * @param Request $request
     * @param int $userId
     * @return self|false
     */
    public static function updateIsCompleted(Request $request, int $userId): self|false
    {
        return self::updateOrCreate(
            [
                'user_id' => $userId,
                'course_id'  => $request->id
            ],
            [
                'is_completed' => $request->is_completed
            ]
        );
    }

    /**
     * 視聴開始日時の設定
     *
     * @param Request $request
     * @param int $userId
     * @return self|false
     */
    public static function setFirstPlayedTime(Request $request, int $userId): self|false
    {
        $course_progress = self::where('user_id', $userId)->where('course_id', $request->id)->first();

        if($course_progress) {
            if(!$course_progress->first_played_at) {
                $course_progress->first_played_at =  Carbon::now()->format('Y-m-d H:i:s');
                $course_progress->is_watched = 1;
                $course_progress->save();
            }
        } else {
            $course_progress = new UserCourseProgress();
            $course_progress->user_id = $userId;
            $course_progress->course_id = $request->id;
            $course_progress->first_played_at =  Carbon::now()->format('Y-m-d H:i:s');
            $course_progress->is_watched = 1;
            $course_progress->save();
        }
        return $course_progress;
    }

    /**
     * 視聴終了日時の設定
     *
     * @param Request $request
     * @param int $userId
     * @return self|false
     */
    public static function setLastPlayedTime(Request $request, int $userId): self|false
    {
        $course_progress = self::where('user_id', $userId)->where('course_id', $request->id)->first();

        if($course_progress) {
            if(!$course_progress->last_played_at) {
                $course_progress->is_watched = 1;
                $course_progress->last_played_at =  Carbon::now()->format('Y-m-d H:i:s');
            }
            $course_progress->played_count = $course_progress->played_count + 1;
            $course_progress->save();
        } else {
            $course_progress = new UserCourseProgress();
            $course_progress->user_id = $userId;
            $course_progress->course_id = $request->id;
            $course_progress->is_watched = 1;
            $course_progress->last_played_at =  Carbon::now()->format('Y-m-d H:i:s');
            $course_progress->played_count = 1;
            $course_progress->save();
        }
        return $course_progress;
    }
}
