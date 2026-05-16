<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display reports dashboard
     */
    public function index(): View
    {
        return view('admin.reports.index');
    }

    /**
     * Generate attendance report
     */
    public function attendanceReport(Request $request): View
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'student_id' => 'nullable|exists:students,id',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        $query = AttendanceRecord::with(['student.user', 'subject']);

        if ($request->has('start_date') && $request->start_date) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        $records = $query->orderBy('date', 'desc')->paginate(50);

        // Calculate statistics
        $stats = [
            'total' => $query->count(),
            'present' => (clone $query)->where('status', 'present')->count(),
            'absent' => (clone $query)->where('status', 'absent')->count(),
            'late' => (clone $query)->where('status', 'late')->count(),
        ];

        $students = Student::with('user')->get();
        $subjects = Subject::all();

        return view('admin.reports.attendance', compact('records', 'stats', 'students', 'subjects'));
    }

    /**
     * Export attendance report to PDF
     */
    public function exportAttendancePDF(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'student_id' => 'nullable|exists:students,id',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        $query = AttendanceRecord::with(['student.user', 'subject']);

        if ($request->start_date) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->where('date', '<=', $request->end_date);
        }

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        $records = $query->orderBy('date', 'desc')->get();

        $stats = [
            'total' => $records->count(),
            'present' => $records->where('status', 'present')->count(),
            'absent' => $records->where('status', 'absent')->count(),
            'late' => $records->where('status', 'late')->count(),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.attendance', compact('records', 'stats'));
        
        return $pdf->download('attendance-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Generate grade report
     */
    public function gradeReport(Request $request): View
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'grade_type' => 'nullable|in:quiz,exam,project,assignment,final',
        ]);

        $query = Grade::with(['student.user', 'subject', 'teacher.user']);

        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('grade_type') && $request->grade_type) {
            $query->where('grade_type', $request->grade_type);
        }

        $grades = $query->orderBy('created_at', 'desc')->paginate(50);

        // Calculate statistics
        $stats = [
            'total' => $query->count(),
            'average' => $query->avg('grade'),
            'highest' => $query->max('grade'),
            'lowest' => $query->min('grade'),
        ];

        $students = Student::with('user')->get();
        $subjects = Subject::all();

        return view('admin.reports.grades', compact('grades', 'stats', 'students', 'subjects'));
    }

    /**
     * Export grade report to PDF
     */
    public function exportGradePDF(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'nullable|exists:students,id',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        $query = Grade::with(['student.user', 'subject', 'teacher.user']);

        if ($request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        $grades = $query->orderBy('created_at', 'desc')->get();

        $stats = [
            'total' => $grades->count(),
            'average' => $grades->avg('grade'),
            'highest' => $grades->max('grade'),
            'lowest' => $grades->min('grade'),
        ];

        $pdf = Pdf::loadView('admin.reports.pdf.grades', compact('grades', 'stats'));
        
        return $pdf->download('grade-report-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Display analytics dashboard
     */
    public function analytics(): View
    {
        // Overall statistics
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalSubjects = Subject::count();

        // Attendance statistics (last 30 days)
        $attendanceStats = AttendanceRecord::where('date', '>=', now()->subDays(30))
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Grade distribution
        $gradeDistribution = [
            'excellent' => Grade::where('grade', '>=', 90)->count(),
            'very_good' => Grade::whereBetween('grade', [80, 89.99])->count(),
            'good' => Grade::whereBetween('grade', [75, 79.99])->count(),
            'needs_improvement' => Grade::where('grade', '<', 75)->count(),
        ];

        // Recent activity
        $recentAttendance = AttendanceRecord::with(['student.user', 'subject'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $recentGrades = Grade::with(['student.user', 'subject'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Top performing students
        $topStudents = Student::with('user')
            ->withAvg('grades', 'grade')
            ->orderBy('grades_avg_grade', 'desc')
            ->limit(10)
            ->get();

        // Absentee Trends (last 14 days)
        $absenteeTrends = AttendanceRecord::where('status', 'absent')
            ->where('date', '>=', now()->subDays(14))
            ->selectRaw('date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Subject Attendance Percentage
        $subjectAttendance = Subject::withCount(['attendanceRecords', 'attendanceRecords as present_count' => function($query) {
                $query->where('status', 'present');
            }])->get()->map(function($subject) {
                $total = $subject->attendance_records_count;
                $subject->attendance_percentage = $total > 0 ? round(($subject->present_count / $total) * 100, 1) : 0;
                return $subject;
            })->sortByDesc('attendance_percentage')->take(5);

        return view('admin.analytics', compact(
            'totalStudents',
            'totalTeachers',
            'totalSubjects',
            'attendanceStats',
            'gradeDistribution',
            'recentAttendance',
            'recentGrades',
            'topStudents',
            'absenteeTrends',
            'subjectAttendance'
        ));
    }

    /**
     * Generate student transcript
     */
    public function studentTranscript($studentId)
    {
        $student = Student::with(['user', 'course', 'grades.subject'])->findOrFail($studentId);

        $gradesBySubject = $student->grades->groupBy('subject_id')->map(function ($grades) {
            return [
                'subject' => $grades->first()->subject,
                'grades' => $grades,
                'average' => $grades->avg('grade'),
            ];
        });

        $overallAverage = $student->grades->avg('grade');

        $pdf = Pdf::loadView('admin.reports.pdf.transcript', compact('student', 'gradesBySubject', 'overallAverage'));
        
        return $pdf->download('transcript-' . $student->student_id . '-' . now()->format('Y-m-d') . '.pdf');
    }
}
