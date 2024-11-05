<?php

namespace Database\Seeders;

use App\Models\CourseComment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseComment::insert([
            [
                'course_id'         => 1,
                'parent_comment_id' => null,
                'mentioned_user_id' => null,
                'user_id'           => 3,
                'body'              => 'コメントテストです。',
                'created_at'        => '2023-04-29 09:00:00',
                'updated_at'        => '2023-04-29 09:00:00'
            ],
            [
                'course_id'         => 1,
                'parent_comment_id' => 1,
                'mentioned_user_id' => 3,
                'user_id'           => 1,
                'body'              => 'コメントの1つ目の返信です。',
                'created_at'        => '2023-04-29 12:00:00',
                'updated_at'        => '2023-04-29 12:00:00'
            ]
        ]);
    }
}


