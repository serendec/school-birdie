<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\School;
use Faker\Factory;
use Illuminate\Support\Str;

class SchoolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'name'                   => 'AAAスクール',
            'tel'                    => '03-1234-5678',
            'email'                  => 'info@aaaschool.com',
            'url'                    => 'https://aaaschool.com',
            'icon'                   => 'catcCJvhGdAPnFunhCGzqcV89By0NEzUjmkDKBqD.jpg',
            'register_teacher_token' => bcrypt('password'),
        ]);

        $faker = Factory::create();
        for ($i = 0; $i < 4; $i++) {
            $school_head = Str::random(3);
            School::create([
                'name'                   => $school_head.'スクール',
                'tel'                    => '03-'.$faker->unique()->numerify('####-####'),
                'email'                  => 'info@'.$school_head.'school.com',
                'url'                    => 'https://'.$school_head.'school.com',
                'register_teacher_token' => bcrypt('password'),
            ]);
        }
    }
}
