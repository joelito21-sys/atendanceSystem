<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ParentModel;
use App\Models\Subject;
use App\Models\ClassSchedule;
use App\Models\QrCode;
use App\Models\AttendanceRecord;
use App\Models\Grade;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CourseSeeder::class,
            SubjectSeeder::class,
            PreEnrollmentSeeder::class,
        ]);

        // Create Admin User

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Teachers
        $teachers = [];
        $teacherData = [
            ['name' => 'John Smith', 'email' => 'john.smith@school.com', 'employee_id' => 'TCH-001', 'department' => 'Mathematics'],
            ['name' => 'Maria Garcia', 'email' => 'maria.garcia@school.com', 'employee_id' => 'TCH-002', 'department' => 'Science'],
            ['name' => 'David Johnson', 'email' => 'david.johnson@school.com', 'employee_id' => 'TCH-003', 'department' => 'English'],
        ];

        foreach ($teacherData as $td) {
            $user = User::create([
                'name' => $td['name'],
                'email' => $td['email'],
                'password' => Hash::make('password'),
                'role' => 'teacher',
            ]);

            $teachers[] = Teacher::create([
                'user_id' => $user->id,
                'employee_id' => $td['employee_id'],
                'department' => $td['department'],
            ]);
        }

        // Create Parents
        $parents = [];
        $parentData = [
            ['name' => 'Robert Wilson', 'email' => 'robert.wilson@email.com', 'notification_email' => 'robert.wilson@email.com'],
            ['name' => 'Jennifer Brown', 'email' => 'jennifer.brown@email.com', 'notification_email' => 'jennifer.brown@email.com'],
            ['name' => 'Michael Davis', 'email' => 'michael.davis@email.com', 'notification_email' => 'michael.davis@email.com'],
        ];

        foreach ($parentData as $pd) {
            $user = User::create([
                'name' => $pd['name'],
                'email' => $pd['email'],
                'password' => Hash::make('password'),
                'role' => 'parent',
            ]);

            $parents[] = ParentModel::create([
                'user_id' => $user->id,
                'notification_email' => $pd['notification_email'],
                'relationship' => 'Parent',
                'receive_notifications' => true,
            ]);
        }

        // Create Subjects
        $subjects = [];
        $subjectData = [
            ['name' => 'Mathematics', 'code' => 'MATH-101', 'teacher' => 0],
            ['name' => 'Science', 'code' => 'SCI-101', 'teacher' => 1],
            ['name' => 'English', 'code' => 'ENG-101', 'teacher' => 2],
            ['name' => 'Filipino', 'code' => 'FIL-101', 'teacher' => 2],
            ['name' => 'History', 'code' => 'HIST-101', 'teacher' => 0],
        ];

        foreach ($subjectData as $sd) {
            $subjects[] = Subject::create([
                'name' => $sd['name'],
                'code' => $sd['code'],
                'teacher_id' => $teachers[$sd['teacher']]->id,
                'grade_level' => 'Grade 10',
                'units' => 3,
                'is_active' => true,
            ]);
        }

        // Create Class Schedules
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($subjects as $index => $subject) {
            ClassSchedule::create([
                'subject_id' => $subject->id,
                'day_of_week' => $days[$index % 5],
                'start_time' => '08:00',
                'end_time' => '09:00',
                'room' => 'Room ' . ($index + 101),
                'section' => 'Einstein',
            ]);
        }

        // Create Students
        $students = [];
        $studentData = [
            ['name' => 'Alice Johnson', 'email' => 'alice.johnson@student.school.com', 'id_number' => '2024-0001', 'parent' => 0],
            ['name' => 'Bob Williams', 'email' => 'bob.williams@student.school.com', 'id_number' => '2024-0002', 'parent' => 1],
            ['name' => 'Carol Martinez', 'email' => 'carol.martinez@student.school.com', 'id_number' => '2024-0003', 'parent' => 2],
            ['name' => 'Daniel Lee', 'email' => 'daniel.lee@student.school.com', 'id_number' => '2024-0004', 'parent' => 0],
            ['name' => 'Emma Thompson', 'email' => 'emma.thompson@student.school.com', 'id_number' => '2024-0005', 'parent' => 1],
        ];

        foreach ($studentData as $sd) {
            $user = User::create([
                'name' => $sd['name'],
                'email' => $sd['email'],
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            $student = Student::create([
                'user_id' => $user->id,
                'student_id_number' => $sd['id_number'],
                'parent_id' => $parents[$sd['parent']]->id,
                'grade_level' => 'Grade 10',
                'section' => 'Einstein',
            ]);

            $students[] = $student;

            // Generate QR code for student
            QrCode::generateForStudent($student);

            // Enroll in all subjects
            foreach ($subjects as $subject) {
                $student->subjects()->attach($subject->id, [
                    'school_year' => '2024-2025',
                    'semester' => '1st Semester',
                    'is_active' => true,
                ]);
            }
        }

        // Create Sample Attendance Records
        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                for ($i = 0; $i < 5; $i++) {
                    $date = now()->subDays($i);
                    $status = rand(0, 10) > 8 ? 'late' : 'present';
                    
                    AttendanceRecord::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'date' => $date->format('Y-m-d'),
                        'time_in' => '08:0' . rand(0, 9) . ':00',
                        'time_out' => '09:00:00',
                        'status' => $status,
                    ]);
                }
            }
        }

        // Create Sample Grades
        $gradeTypes = ['quiz', 'oral', 'written', 'project'];
        foreach ($students as $student) {
            foreach ($subjects as $subject) {
                foreach ($gradeTypes as $type) {
                    $total = $type === 'project' ? 100 : ($type === 'written' ? 50 : 20);
                    Grade::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'type' => $type,
                        'title' => ucfirst($type) . ' 1',
                        'score' => rand(floor($total * 0.6), $total),
                        'total_score' => $total,
                        'grading_period' => '1st',
                        'date_given' => now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('-------------------');
        $this->command->info('Admin: admin@school.com / password');
        $this->command->info('Teacher: john.smith@school.com / password');
        $this->command->info('Student: alice.johnson@student.school.com / password');
        $this->command->info('Parent: robert.wilson@email.com / password');
    }
}
