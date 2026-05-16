<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\AttendanceRecord;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentDashboardController extends Controller
{
    /**
     * Display the parent dashboard with children overview
     */
    public function index()
    {
        $parent = Auth::user()->parent;
        
        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $children = $parent->students()->with(['course', 'subjects'])->get();
        
        // Get summary data for each child
        $childrenData = $children->map(function ($child) {
            return [
                'student' => $child,
                'attendance_rate' => $this->calculateAttendanceRate($child),
                'average_grade' => $this->calculateAverageGrade($child),
                'recent_absences' => $this->getRecentAbsences($child),
                'subject_count' => $child->subjects->count(),
            ];
        });

        return view('parent.dashboard', compact('childrenData'));
    }

    /**
     * Display detailed information about a specific child
     */
    public function showChild($studentId)
    {
        $parent = Auth::user()->parent;
        
        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $student = $parent->students()->with(['course', 'subjects.teacher'])->findOrFail($studentId);

        return view('parent.child-details', compact('student'));
    }

    /**
     * Display attendance records for a specific child
     */
    public function childAttendance($studentId)
    {
        $parent = Auth::user()->parent;
        
        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $student = $parent->students()->findOrFail($studentId);
        
        $attendanceRecords = AttendanceRecord::where('student_id', $studentId)
            ->with(['subject', 'classSchedule'])
            ->orderBy('date', 'desc')
            ->paginate(20);

        $attendanceStats = [
            'total_days' => AttendanceRecord::where('student_id', $studentId)->distinct('date')->count(),
            'present_days' => AttendanceRecord::where('student_id', $studentId)
                ->where('status', 'present')
                ->distinct('date')
                ->count(),
            'absent_days' => AttendanceRecord::where('student_id', $studentId)
                ->where('status', 'absent')
                ->distinct('date')
                ->count(),
            'late_days' => AttendanceRecord::where('student_id', $studentId)
                ->where('status', 'late')
                ->distinct('date')
                ->count(),
        ];

        return view('parent.child-attendance', compact('student', 'attendanceRecords', 'attendanceStats'));
    }

    /**
     * Display grades for a specific child
     */
    public function childGrades($studentId)
    {
        $parent = Auth::user()->parent;
        
        if (!$parent) {
            abort(403, 'Parent profile not found.');
        }

        $student = $parent->students()->with('subjects')->findOrFail($studentId);
        
        $grades = Grade::where('student_id', $studentId)
            ->with(['subject'])
            ->orderBy('date_given', 'desc')
            ->get();

        // Group grades by subject and use weighted calculation
        $gradesBySubject = $student->subjects->map(function ($subject) use ($studentId, $grades) {
            $subjectGrades = $grades->where('subject_id', $subject->id);
            $weightedData = Grade::calculateWeightedGrade($studentId, $subject->id);
            
            return [
                'subject' => $subject,
                'grades' => $subjectGrades,
                'weighted' => $weightedData,
                'average' => $weightedData['final'],
            ];
        })->filter(function($data) {
            return $data['grades']->count() > 0;
        });

        $overallAverage = $gradesBySubject->count() > 0 ? $gradesBySubject->avg('average') : 0;

        return view('parent.child-grades', compact('student', 'gradesBySubject', 'overallAverage'));
    }

    /**
     * Calculate attendance rate for a student
     */
    private function calculateAttendanceRate($student)
    {
        $totalRecords = AttendanceRecord::where('student_id', $student->id)->count();
        
        if ($totalRecords === 0) {
            return 0;
        }

        $presentRecords = AttendanceRecord::where('student_id', $student->id)
            ->where('status', 'present')
            ->count();

        return round(($presentRecords / $totalRecords) * 100, 1);
    }

    /**
     * Calculate average grade for a student
     */
    private function calculateAverageGrade($student)
    {
        $subjects = $student->subjects;
        if ($subjects->isEmpty()) return null;

        $averages = [];
        foreach ($subjects as $subject) {
            $weightedData = Grade::calculateWeightedGrade($student->id, $subject->id);
            if (Grade::where('student_id', $student->id)->where('subject_id', $subject->id)->exists()) {
                $averages[] = $weightedData['final'];
            }
        }
        
        return !empty($averages) ? round(array_sum($averages) / count($averages), 1) : null;
    }

    /**
     * Get recent absences for a student
     */
    private function getRecentAbsences($student)
    {
        return AttendanceRecord::where('student_id', $student->id)
            ->where('status', 'absent')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get();
    }
}
