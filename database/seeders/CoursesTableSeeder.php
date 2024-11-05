<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::insert([
            [
                'title'             => '講座タイトル',
                'video'             => 'ZEBIr6bbNjfL2zA7VgOMRvIB6iNC9pMjboTDzPXI.mov',
                'video_duration'    => 130,
                'content'           => '左手を意識します。',
                'category_id'       => 1,
                'school_id'         => 1,
                'post_status'       => 'publish',
                'display_order'     => 1,
                'created_at'        => '2023-04-29 09:00:00',
                'updated_at'        => '2023-04-29 09:00:00'
            ],
            [
                'title'             => 'グリップの握り方',
                'video'             => '',
                'video_duration'    => null,
                'content'           => '右手は添えるだけ。',
                'category_id'       => 1,
                'school_id'         => 1,
                'post_status'       => 'draft',
                'display_order'     => 2,
                'created_at'        => '2023-04-29 11:00:00',
                'updated_at'        => '2023-04-29 11:00:00'
            ],
            [
                'title'             => 'アドレスのとり方',
                'video'             => '',
                'video_duration'    => null,
                'content'           => 'ボールの真下にヘッドを置きます。',
                'category_id'       => 1,
                'school_id'         => 1,
                'post_status'       => 'publish',
                'display_order'     => 3,
                'created_at'        => '2023-04-29 13:00:00',
                'updated_at'        => '2023-04-29 13:00:00'
            ],
            [
                'title'             => 'スイングの動き',
                'video'             => '',
                'video_duration'    => null,
                'content'           => '腰を回します。',
                'category_id'       => 1,
                'school_id'         => 1,
                'post_status'       => 'publish',
                'display_order'     => 4,
                'created_at'        => '2023-04-29 15:00:00',
                'updated_at'        => '2023-04-29 15:00:00'
            ],
            [
                'title'             => 'フォロースルー',
                'video'             => '',
                'video_duration'    => null,
                'content'           => '腰を回します。',
                'category_id'       => 1,
                'school_id'         => 1,
                'post_status'       => 'publish',
                'display_order'     => 5,
                'created_at'        => '2023-04-29 17:00:00',
                'updated_at'        => '2023-04-29 17:00:00'
            ],
            [
                'title'             => 'アプローチ',
                'video'             => '',
                'video_duration'    => null,
                'content'           => '腰を回します。',
                'category_id'       => 1,
                'school_id'         => 1,
                'post_status'       => 'publish',
                'display_order'     => 6,
                'created_at'        => '2023-04-29 19:00:00',
                'updated_at'        => '2023-04-29 19:00:00'
            ],
            [
                'title'             => '飛距離を伸ばす',
                'video'             => '',
                'video_duration'    => null,
                'content'           => '捻転を意識します。',
                'category_id'       => 2,
                'school_id'         => 1,
                'post_status'       => 'publish',
                'display_order'     => 1,
                'created_at'        => '2023-04-29 21:00:00',
                'updated_at'        => '2023-04-29 21:00:00'
            ],
            [
                'title'             => 'ピンの高さ',
                'video'             => '',
                'video_duration'    => null,
                'content'           => '自分の最適な高さを見つけます。',
                'category_id'       => 2,
                'school_id'         => 1,
                'post_status'       => 'publish',
                'display_order'     => 2,
                'created_at'        => '2023-04-29 22:00:00',
                'updated_at'        => '2023-04-29 22:00:00'
            ]
        ]);
    }
}


