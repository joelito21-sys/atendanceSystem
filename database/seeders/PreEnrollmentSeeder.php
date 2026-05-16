<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PreEnrollment;
use App\Models\User;
use App\Models\ParentModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

                $student = Student::create([
                    'user_id' => $studentUser->id,
                    'student_id_number' => $entry['student_id_number'],
                    'section' => $entry['section'],
                ]);
            } else {
                $student = $studentUser->student;
            }

            // 2. Create Parent account if it doesn't exist
            $parentUser = User::where('email', $entry['parent_email'])->first();
            if (!$parentUser) {
                $parentUser = User::create([
                    'name' => 'Parent of ' . $entry['student_name'],
                    'email' => $entry['parent_email'],
                    'password' => Hash::make('password'),
                    'role' => 'parent',
                ]);

                $parentProfile = ParentModel::create([
                    'user_id' => $parentUser->id,
                    'relationship' => 'Guardian',
                    'notification_email' => $entry['parent_email'],
                ]);
            } else {
                $parentProfile = $parentUser->parentProfile;
            }

            if ($student && $parentProfile) {
                $student->update(['parent_id' => $parentProfile->id]);
            }

            foreach ($entry['subjects'] as $subjectCode) {
                PreEnrollment::create([
                    'student_id_number' => $entry['student_id_number'],
                    'student_name' => $entry['student_name'],
                    'student_email' => $entry['student_email'],
                    'parent_email' => $entry['parent_email'],
                    'subject_code' => $subjectCode,
                    'section' => $entry['section'],
                    'school_year' => '2025-2026',
                    'semester' => '1st Semester',
                ]);
            }
        }
    }
}
