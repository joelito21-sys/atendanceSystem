<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Course::create([
            'name' => 'Bachelor of Science in Information Technology',
            'code' => 'BSIT',
        ]);

        \App\Models\Course::create([
            'name' => 'Bachelor of Science in Computer Science',
            'code' => 'BSCS',
        ]);

        \App\Models\Course::create([
            'name' => 'Bachelor of Science in Hotel and Restaurant Management',
            'code' => 'HRM',
        ]);

    }
}
