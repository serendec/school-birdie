<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::insert([
            [
                'school_id' => 1,
                'name' => 'ドライバー',
            ],
            [
                'school_id' => 1,
                'name' => 'アイアン',
            ],
            [
                'school_id' => 1,
                'name' => 'パター',
            ],
            [
                'school_id' => 1,
                'name' => 'スライス',
            ],
        ]);
    }
}
