<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class StudentProfile extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the student profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the lesson plan associated with the student profile.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lessonPlan()
    {
        return $this->belongsTo(LessonPlan::class);
    }

    /**
     * 更新
     *
     * @param Request $request
     * @return bool
     */
    public static function updateFromRequest(Request $request): bool
    {
        $studentProfile = self::where('user_id', $request->id)->first();
        $studentProfile->lesson_plan_id = $request->lesson_plan_id;
        return $studentProfile->save();
    }
}
