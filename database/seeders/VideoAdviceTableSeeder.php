<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\VideoAdvice;
use Illuminate\Database\Seeder;

class VideoAdviceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VideoAdvice::insert(
            [
                [
                    'student_id' => User::where('role', 'student')->where('school_id', 1)->value('id'),
                    'title' => 'スライス改善',
                    'video' => 'jXFxcBy2rXRPMnSEj7Z77K9032nkGtowECtqPamI.mov',
                    'question' => 'フェースが開いてしまい、ボールがまっすぐ飛びません。',
                    'status' => 'open',
                    'created_at' => '2023-04-26 12:00:00',
                    'updated_at' => '2023-04-26 12:00:00'
                ],
                [
                    'student_id' => 3,
                    'title' => '飛距離アップ',
                    'video' => 'ZEBIr6bbNjfL2zA7VgOMRvIB6iNC9pMjboTDzPXI.mov',
                    'question' => '遠くに飛ばすにはどうしたら良いですか。',
                    'status' => 'open',
                    'created_at' => '2023-04-30 07:00:00',
                    'updated_at' => '2023-04-30 07:00:00'
                ]
            ]
        );
    }
}
