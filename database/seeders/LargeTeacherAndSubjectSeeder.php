<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassSchedule;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;

class LargeTeacherAndSubjectSeeder extends Seeder
{
    public function run(): void
    {
        $courseIds = Course::pluck('id')->toArray();
        if (empty($courseIds)) {
            $course = Course::create(['name' => 'General Education', 'code' => 'GEN-ED']);
            $courseIds = [$course->id];
        }

        $teacherData = [
            ['name' => 'John Smith', 'email' => 'john.smith@school.com', 'dept' => 'Mathematics'],
            ['name' => 'Maria Garcia', 'email' => 'maria.garcia@school.com', 'dept' => 'Science'],
            ['name' => 'David Johnson', 'email' => 'david.johnson@school.com', 'dept' => 'English'],
            ['name' => 'Robert Wilson', 'email' => 'robert.wilson@school.com', 'dept' => 'History'],
            ['name' => 'Emma Davis', 'email' => 'emma.davis@school.com', 'dept' => 'Social Studies'],
            ['name' => 'Michael Brown', 'email' => 'michael.brown@school.com', 'dept' => 'Values Education'],
            ['name' => 'Sarah Miller', 'email' => 'sarah.miller@school.com', 'dept' => 'Filipino'],
        ];

        $subjectNames = [
            'Mathematics' => ['Algebra 101', 'Geometry Basics', 'Advanced Calculus'],
            'Science' => ['Biology I', 'Chemistry Lab', 'Physics Principles'],
            'English' => ['World Literature', 'Creative Writing', 'Technical Comm'],
            'History' => ['Modern World History', 'Asian Studies', 'Political Science'],
            'Social Studies' => ['Economics 101', 'Ethics & Society', 'Geography'],
            'Values Education' => ['Personal Development', 'Leadership 101', 'Christian Living'],
            'Filipino' => ['Retorika', 'Panitikan', 'Wika at Kultura'],
        ];

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [
            ['08:00', '09:00'],
            ['09:00', '10:00'],
            ['10:30', '11:30']
        ];

        foreach ($teacherData as $index => $td) {
            // 1. Create or Update Teacher User
            $user = User::updateOrCreate(
                ['email' => $td['email']],
                [
                    'name' => $td['name'],
                    'password' => Hash::make('password'),
                    'role' => 'teacher',
                ]
            );

            $teacher = Teacher::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'employee_id' => 'TCH-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'department' => $td['dept'],
                ]
            );

            // 2. Create 3 Subjects per Teacher
            $deptsSubjects = $subjectNames[$td['dept']] ?? ['Subject A', 'Subject B', 'Subject C'];
            
            foreach ($deptsSubjects as $subIndex => $subName) {
                $subCode = strtoupper(substr($td['dept'], 0, 3)) . '-' . (100 + $subIndex + ($index * 10));
                
                $subject = Subject::updateOrCreate(
                    ['code' => $subCode],
                    [
                        'name' => $subName,
                        'teacher_id' => $teacher->id,
                        'course_id' => $courseIds[$index % count($courseIds)],
                        'grade_level' => 'Grade 10',
                        'units' => 3,
                        'is_active' => true,
                        'year_level' => '1st Year',
                        'semester' => '1st Semester'
                    ]
                );

                // 3. Create Schedule for each Subject
                ClassSchedule::updateOrCreate(
                    ['subject_id' => $subject->id],
                    [
                        'day_of_week' => $days[$subIndex % 5],
                        'start_time' => $timeSlots[$subIndex][0],
                        'end_time' => $timeSlots[$subIndex][1],
                        'room' => 'Room ' . (100 + $index + $subIndex),
                        'section' => 'A',
                    ]
                );
            }
        }

        $this->command->info('Successfully created 7 teachers with 3 subjects each (Total 21 subjects).');
    }
}
