<?php

namespace Database\Seeders;

use App\Models\VideoAdvice;
use App\Models\VideoAdviceComment;
use Illuminate\Database\Seeder;

class VideoAdviceCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VideoAdviceComment::insert([
            [
                'video_advice_id'   => 1,
                'parent_comment_id' => null,
                'mentioned_user_id' => 3,
                'user_id'           => 1,
                'body'              => 'コメントテストです。',
                'created_at'        => '2023-04-26 09:00:00',
                'updated_at'        => '2023-04-26 09:00:00'
            ],
            [
                'video_advice_id'   => 1,
                'parent_comment_id' => 1,
                'mentioned_user_id' => 1,
                'user_id'           => 3,
                'body'              => 'コメントの1つ目の返信です。',
                'created_at'        => '2023-04-26 12:00:00',
                'updated_at'        => '2023-04-26 12:00:00'
            ]
        ]);
    }
}
