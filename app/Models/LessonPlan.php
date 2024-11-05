<?php

namespace App\Models;

use App\Traits\BySchoolIdTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonPlan extends Model
{
    use HasFactory, BySchoolIdTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'school_id',
        'name',
        'price',
        'stripe_plan_id',
        'video_advice_available',
        'video_advice_num',
        'video_advice_automatically_close_period',
        'course_available',
        'lesson_record_available',
        'forum_available'
    ];

    /**
     * Get the student profiles associated with the lesson plan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentProfile()
    {
        return $this->hasMany(StudentProfile::class, 'lesson_plan_id');
    }

    /**
     * 受講プラン一覧を取得
     * 
     * @param int $schoolId
     * @return Collection|null
     */
    public static function getLessonPlans(int $schoolId): ?Collection
    {
        return self::bySchoolId($schoolId)->get();
    }

    /**
     * 受講プラン詳細を取得
     *
     * @param int $lesson_plan_id
     * @param int $schoolId
     * @return LessonPlan|null
     */
    public static function getLessonPlan(int $lesson_plan_id, int $schoolId): ?LessonPlan
    {
        return self::where('id', $lesson_plan_id)
                    ->bySchoolId($schoolId)
                    ->first();
    }
}
