<?php

namespace Database\Seeders;

use App\Models\ForumComment;
use App\Models\ForumCommentLike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ForumCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ForumComment::insert([
            [
                'forum_id'          => 1,
                'parent_comment_id' => null,
                'mentioned_user_id' => 1,
                'user_id'           => 3,
                'body'              => 'フォーラムのコメントテストです。',
                'created_at'        => '2023-04-29 10:00:00',
                'updated_at'        => '2023-04-29 10:00:00'
            ],
            [
                'forum_id'          => 1,
                'parent_comment_id' => 1,
                'mentioned_user_id' => 3,
                'user_id'           => 1,
                'body'              => 'フォーラムコメントの1つ目の返信です。',
                'created_at'        => '2023-04-29 12:00:00',
                'updated_at'        => '2023-04-29 12:00:00'
            ]
        ]);

        ForumCommentLike::insert([
            [
                'forum_comment_id'  => 1,
                'user_id'           => 2,
                'created_at'        => '2023-04-29 11:00:00',
                'updated_at'        => '2023-04-29 11:00:00'
            ],
            [
                'forum_comment_id'  => 1,
                'user_id'           => 4,
                'created_at'        => '2023-04-29 11:30:00',
                'updated_at'        => '2023-04-29 11:30:00'
            ],
            [
                'forum_comment_id'  => 2,
                'user_id'           => 5,
                'created_at'        => '2023-04-29 12:00:00',
                'updated_at'        => '2023-04-29 12:00:00'
            ]
        ]);
    }
}


