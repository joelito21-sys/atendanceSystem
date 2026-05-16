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
        \App\Models\Course::firstOrCreate(
            ['code' => 'BSIT'],
            ['name' => 'Bachelor of Science in Information Technology']
        );

        \App\Models\Course::firstOrCreate(
            ['code' => 'BSCS'],
            ['name' => 'Bachelor of Science in Computer Science']
        );

        \App\Models\Course::firstOrCreate(
            ['code' => 'HRM'],
            ['name' => 'Bachelor of Science in Hotel and Restaurant Management']
        );
    }
}
