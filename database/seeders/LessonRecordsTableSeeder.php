<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\LessonRecord;
use App\Models\StudentTeacherRelation;
use Illuminate\Database\Seeder;

class LessonRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        LessonRecord::insert([
            [
                'teacher_id'      => 1,
                'student_id'      => 3,
                'title'           => 'スライス改善',
                'summary'         => 'フィードバックの更新です。スライスね。改行です。',
                'teacher_comment' => '体の開きに注意してください。',
                'school_memo'     => 'スクール用のメモです。これは直すのに時間がかかりそうです。',
                'lesson_date'     => '2023-04-15',
                'post_status'     => 'publish',
                'created_at'      => '2021-04-15 00:00:00',
                'updated_at'      => '2021-04-15 00:00:00'
            ],
            [
                'teacher_id'      => 1,
                'student_id'      => 3,
                'title'           => 'ハーフスイング',
                'summary'         => 'ハーフスイングで確実性を増す',
                'teacher_comment' => '手打ちに注意しましょう。',
                'school_memo'     => 'スクール用のメモです。memo。',
                'lesson_date'     => '2023-04-22',
                'post_status'     => 'draft',
                'created_at'      => '2021-04-22 00:00:00',
                'updated_at'      => '2021-04-22 00:00:00'
            ]
        ]);

        $student = Student::where('role', 'student')
                            ->where('school_id', 1)
                            ->get()
                            ->random();
        $teacher = StudentTeacherRelation::where('student_id', $student->id)->first();
        LessonRecord::insert([
            [
                'teacher_id'      => $teacher->teacher_id,
                'student_id'      => $student->id,
                'title'           => 'フック改良',
                'summary'         => 'フックが上達しました。反復メニューを5回行いました。',
                'teacher_comment' => '肩の開きに注意してください。',
                'school_memo'     => 'スクール用のメモです。かなり上手です、ラウンドを一緒に回るコースに引き入れたい。',
                'lesson_date'     => '2023-04-17',
                'post_status'     => 'publish',
                'created_at'      => '2021-04-17 00:00:00',
                'updated_at'      => '2021-04-17 00:00:00'
            ],
            [
                'teacher_id'      => $teacher->teacher_id,
                'student_id'      => $student->id,
                'title'           => 'トップ改善',
                'summary'         => 'トップ改善のメニューを行いました。',
                'teacher_comment' => 'ボールから目を離さないように注意してください。',
                'school_memo'     => 'スクール用のメモです。何度言っても3秒後に忘れる。',
                'lesson_date'     => '2023-04-24',
                'post_status'     => 'publish',
                'created_at'      => '2021-04-24 00:00:00',
                'updated_at'      => '2021-04-24 00:00:00'
            ]
        ]);
    }
}
