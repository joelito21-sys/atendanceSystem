<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreEnrollment;
use App\Models\User;
use App\Models\ParentModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Student;

class PreEnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'student_id_number' => 'STU-2026-001',
                'student_name' => 'John Doe',
                'student_email' => 'student1@example.com',
                'parent_email' => 'parent1@example.com',
                'subjects' => ['BSIT-IT101', 'BSIT-IT102', 'BSIT-MATH101'],
                'section' => 'Einstein',
            ],
            [
                'student_id_number' => 'STU-2026-002',
                'student_name' => 'Jane Smith',
                'student_email' => 'student2@example.com',
                'parent_email' => 'parent2@example.com',
                'subjects' => ['BSCS-CS101', 'BSCS-CS102', 'BSCS-CS103'],
                'section' => 'Newton',
            ],
        ];

        foreach ($data as $entry) {
            // 1. Create Student account if it doesn't exist
            $studentUser = User::where('email', $entry['student_email'])->first();
            if (!$studentUser) {
                $studentUser = User::create([
                    'name' => $entry['student_name'],
                    'email' => $entry['student_email'],
                    'password' => Hash::make('password'),
                    'role' => 'student',
                ]);
            }

            $student = Student::firstOrCreate(
                ['student_id_number' => $entry['student_id_number']],
                [
                    'user_id' => $studentUser->id,
                    'section' => $entry['section'],
                    'grade_level' => '1st Year',
                ]
            );
            if (!$student->user_id) {
                $student->update(['user_id' => $studentUser->id]);
            }

            // 2. Create Parent account if it doesn't exist
            $parentUser = User::firstOrCreate(
                ['email' => $entry['parent_email']],
                [
                    'name' => 'Parent of ' . $entry['student_name'],
                    'password' => Hash::make('password'),
                    'role' => 'parent',
                ]
            );

            $parentProfile = ParentModel::firstOrCreate(
                ['user_id' => $parentUser->id],
                [
                    'relationship' => 'Guardian',
                    'notification_email' => $entry['parent_email'],
                ]
            );

            if ($student && $parentProfile) {
                $student->update(['parent_id' => $parentProfile->id]);
            }

            foreach ($entry['subjects'] as $subjectCode) {
                PreEnrollment::firstOrCreate([
                    'student_id_number' => $entry['student_id_number'],
                    'subject_code'      => $subjectCode,
                    'school_year'       => '2025-2026',
                    'semester'          => '1st Semester',
                ], [
                    'student_name'  => $entry['student_name'],
                    'student_email' => $entry['student_email'],
                    'parent_email'  => $entry['parent_email'],
                    'section'       => $entry['section'],
                ]);
            }
        }
    }
}
