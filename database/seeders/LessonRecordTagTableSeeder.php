<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LessonRecordTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lesson_record_tag')->insert([
            [
                'lesson_record_id' => 1,
                'tag_id' => 4,
            ],
            [
                'lesson_record_id' => 1,
                'tag_id' => 2,
            ],
            [
                'lesson_record_id' => 3,
                'tag_id' => 3,
            ],
            [
                'lesson_record_id' => 3,
                'tag_id' => 1,
            ],
            [
                'lesson_record_id' => 4,
                'tag_id' => 2,
            ],
        ]);
    }
}
