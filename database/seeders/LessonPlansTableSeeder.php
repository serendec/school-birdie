<?php

namespace Database\Seeders;

use App\Models\LessonPlan;
use Illuminate\Database\Seeder;

class LessonPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LessonPlan::insert([
            [
                'school_id' => 1,
                'name' => '定期コース',
                'price' => null,
                'video_advice_available' => 1,
                'video_advice_num' => 4,
                'video_advice_automatically_close_period' => 7,
                'course_available' => 1,
                'lesson_record_available' => 1,
                'forum_available' => 1,
            ],
            [
                'school_id' => 1,
                'name' => '通い放題コース',
                'price' => null,
                'video_advice_available' => 1,
                'video_advice_num' => 4,
                'video_advice_automatically_close_period' => 7,
                'course_available' => 1,
                'lesson_record_available' => 1,
                'forum_available' => 1,
            ],
            [
                'school_id' => 1,
                'name' => 'オフラインコース',
                'price' => null,
                'video_advice_available' => 0,
                'video_advice_num' => 0,
                'video_advice_automatically_close_period' => 0,
                'course_available' => 0,
                'lesson_record_available' => 0,
                'forum_available' => 0,
            ],
        ]);
    }
}
