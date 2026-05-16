<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class AdminAndTeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Create Teachers
        $teacherData = [
            ['name' => 'John Smith', 'email' => 'john.smith@school.com', 'employee_id' => 'TCH-001', 'department' => 'Mathematics'],
            ['name' => 'Maria Garcia', 'email' => 'maria.garcia@school.com', 'employee_id' => 'TCH-002', 'department' => 'Science'],
            ['name' => 'David Johnson', 'email' => 'david.johnson@school.com', 'employee_id' => 'TCH-003', 'department' => 'English'],
        ];

        foreach ($teacherData as $td) {
            $user = User::firstOrCreate(
                ['email' => $td['email']],
                [
                    'name' => $td['name'],
                    'password' => Hash::make('password'),
                    'role' => 'teacher',
                ]
            );

            Teacher::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'employee_id' => $td['employee_id'],
                    'department' => $td['department'],
                ]
            );
        }

        $this->command->info('Admin and Teacher accounts created/restored successfully!');
    }
}
