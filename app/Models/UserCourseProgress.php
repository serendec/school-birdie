<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
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
        'is_watched',
        'is_completed'
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
}
