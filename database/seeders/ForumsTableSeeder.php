<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\ForumLike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Forum::insert([
            [
                'school_id'         => 1,
                'user_id'           => 1,
                'title'             => 'エポンゴルフはどうですか？',
                'content'           => '初めて投稿します。エポンゴルフを検討してますが、決定打に欠けて迷いに迷っています。どなたかご意見をお聞かせください。',
                'images'            => 'epongolf.png',
                'created_at'        => '2023-04-29 09:00:00',
                'updated_at'        => '2023-04-29 09:00:00'
            ],
            [
                'school_id'         => 1,
                'user_id'           => 2,
                'title'             => 'スライスの直し方',
                'content'           => 'スライスが直らないのですが、みなさんどのくらいで修正できましたか？',
                'images'            => null,
                'created_at'        => '2023-04-29 12:00:00',
                'updated_at'        => '2023-04-29 12:00:00'
            ],
            [
                'school_id'         => 1,
                'user_id'           => 3,
                'title'             => 'おすすめのウェア',
                'content'           => '20代女子です。会社のイベントでゴルフをすることになりました。おすすめのウェアを教えてください。',
                'images'            => null,
                'created_at'        => '2023-04-30 19:00:00',
                'updated_at'        => '2023-04-30 19:00:00'
            ],
            [
                'school_id'         => 1,
                'user_id'           => 4,
                'title'             => 'コーチング',
                'images'            => null,
                'content'           => 'スクールでの教え方について、ご意見ありましたらお聞かせください。',
                'created_at'        => '2023-05-01 12:00:00',
                'updated_at'        => '2023-05-01 12:00:00'
            ],
        ]);

        ForumLike::insert([
            [
                'user_id'           => 1,
                'forum_id'          => 1,
                'created_at'        => '2023-04-29 09:00:00',
                'updated_at'        => '2023-04-29 09:00:00'
            ],
            [
                'user_id'           => 2,
                'forum_id'          => 1,
                'created_at'        => '2023-04-29 09:00:00',
                'updated_at'        => '2023-04-29 09:00:00'
            ],
            [
                'user_id'           => 3,
                'forum_id'          => 1,
                'created_at'        => '2023-04-29 09:00:00',
                'updated_at'        => '2023-04-29 09:00:00'
            ],
            [
                'user_id'           => 4,
                'forum_id'          => 1,
                'created_at'        => '2023-04-29 09:00:00',
                'updated_at'        => '2023-04-29 09:00:00'
            ],
            [
                'user_id'           => 1,
                'forum_id'          => 2,
                'created_at'        => '2023-04-29 12:00:00',
                'updated_at'        => '2023-04-29 12:00:00'
            ],
            [
                'user_id'           => 2,
                'forum_id'          => 2,
                'created_at'        => '2023-04-29 12:00:00',
                'updated_at'        => '2023-04-29 12:00:00'
            ],
            [
                'user_id'           => 3,
                'forum_id'          => 2,
                'created_at'        => '2023-04-29 12:00:00',
                'updated_at'        => '2023-04-29 12:00:00'
            ]
        ]);
    }
}


