<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CourseCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SchoolsTableSeeder::class,
            UsersTableSeeder::class,
            TagsTableSeeder::class,
            LessonPlansTableSeeder::class,
            LessonRecordsTableSeeder::class,
            LessonRecordTagTableSeeder::class,
            VideoAdviceTableSeeder::class,
            VideoAdviceCommentsTableSeeder::class,
            CourseCategoriesTableSeeder::class,
            CoursesTableSeeder::class,
            CourseCommentsTableSeeder::class,
            ForumsTableSeeder::class,
            ForumCommentsTableSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
