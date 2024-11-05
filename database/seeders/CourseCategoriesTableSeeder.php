<?php

namespace Database\Seeders;

use App\Models\CourseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseCategory::insert([
            [
                'name' => '基本動作',
                'school_id' => 1,
                'display_order' => 1,
            ],
            [
                'name' => 'ドライバー',
                'school_id' => 1,
                'display_order' => 2,
            ],
            [
                'name' => 'アイアン',
                'school_id' => 1,
                'display_order' => 3,
            ],
            [
                'name' => 'ユーティリティ',
                'school_id' => 1,
                'display_order' => 4,
            ],
            [
                'name' => 'ルール',
                'school_id' => 1,
                'display_order' => 5,
            ],
        ]);
    }
}


