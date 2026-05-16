<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\ClassSchedule;
use App\Models\Student;
use App\Models\AttendanceRecord;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;

class AssignTeacherSubjectsSeeder extends Seeder
{
    public function run()
    {

        $teachers = Teacher::all();
        $subjects = Subject::all();
        
        if ($teachers->isEmpty()) {
            echo "No teachers found.";
            return;
        }

        // Reset
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ClassSchedule::truncate();
        AttendanceRecord::truncate();
        Grade::truncate();
        DB::table('student_subjects')->truncate();
        Subject::whereNotNull('teacher_id')->update(['teacher_id' => null]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($teachers as $tIndex => $teacher) {
            // Assign exactly 3 subjects
            $teacherSubjects = $subjects->slice($tIndex * 3, 3);
            
            foreach ($teacherSubjects as $sIndex => $subject) {
                $subject->teacher_id = $teacher->id;
                $subject->save();

                // Create schedule
                // If it's the first teacher and first subject, make it "Starting Soon" for today (Thursday)
                if ($tIndex === 0 && $sIndex === 0) {
                    $day = 'Thursday';
                    $start = '20:15'; // 15 mins from now (20:00)
                    $end = '21:45';
                } else {
                    $day = $days[($tIndex + $sIndex) % 5];
                    $start = '08:00';
                    $end = '09:30';
                }

                ClassSchedule::create([
                    'subject_id' => $subject->id,
                    'day_of_week' => $day,
                    'start_time' => $start,
                    'end_time' => $end,
                    'room' => 'Room ' . (100 + $tIndex),
                    'section' => 'SEC-' . chr(65 + $tIndex),
                ]);
            }
        }

        // Setup a student for the dashboards
        $student = Student::first();
        if (!$student) {
            echo "No students found to enroll.";
            return;
        }

        // Enroll student in all teacher-assigned subjects (first 21 subjects)
        $assignedSubjects = Subject::whereNotNull('teacher_id')->get();
        foreach ($assignedSubjects as $sub) {
            DB::table('student_subjects')->insert([
                'student_id' => $student->id,
                'subject_id' => $sub->id,
                'school_year' => '2025-2026',
                'semester' => '1st',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add some attendance records
            AttendanceRecord::create([
                'student_id' => $student->id,
                'subject_id' => $sub->id,
                'date' => now()->subDays(1)->format('Y-m-d'),
                'status' => ['present', 'late', 'absent'][array_rand([0,1,2])],
                'remarks' => 'Seeded record',
            ]);

            // Add some grades
            $score = rand(85, 98);
            Grade::create([
                'student_id' => $student->id,
                'subject_id' => $sub->id,
                'type' => ['quiz', 'exam', 'project', 'participation'][array_rand([0,1,2,3])],
                'title' => 'Evaluation for ' . $sub->code,
                'score' => $score,
                'total_score' => 100,
                'grading_period' => '1st',
                'date_given' => now()->subDays(2),
                'remarks' => 'Good performance',
            ]);
        }

        echo "Seeded " . $assignedSubjects->count() . " subjects across " . $teachers->count() . " teachers, enrolled one student in all of them, and added activity records.";
    }
}
