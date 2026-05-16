<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\AttendanceRecord;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show dashboard based on user role
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return match($user->role) {
            'admin' => $this->adminDashboard(),
            'teacher' => $this->teacherDashboard($user),
            'student' => $this->studentDashboard($user),
            'parent' => $this->parentDashboard($user),
            default => view('dashboard'),
        };
    }

    /**
     * Admin dashboard
     */
    protected function adminDashboard(): View
    {
        $stats = [
            'total_students' => Student::count(),
            'total_teachers' => Teacher::count(),
            'total_subjects' => Subject::count(),
            'today_attendance' => AttendanceRecord::whereDate('date', today())->count(),
        ];

        $recentAttendance = AttendanceRecord::with(['student.user', 'subject'])
            ->latest()
            ->take(10)
            ->get();

        $upcomingHolidays = \App\Models\Holiday::where('date', '>=', now()->toDateString())
            ->orderBy('date', 'asc')
            ->take(3)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAttendance', 'upcomingHolidays'));
    }

    /**
     * Teacher dashboard
     */
    protected function teacherDashboard($user): View
    {
        $teacher = $user->teacher;
        
        if (!$teacher) {
            return view('teacher.dashboard', [
                'subjects' => collect(),
                'todayClasses' => collect(),
                'stats' => ['total_students' => 0, 'avg_attendance' => 0],
                'recentAttendance' => collect(),
                'recentGrades' => collect(),
                'todayHoliday' => \App\Models\Holiday::whereDate('date', today())->first(),
            ]);
        }

        $subjects = $teacher->subjects()->with(['students', 'classSchedules'])->get();
        $subjectIds = $subjects->pluck('id');

        // Stats
        $totalStudents = $subjects->pluck('students')->flatten()->unique('id')->count();
        
        // Avg Attendance for teacher's subjects (last 30 days)
        $attendanceData = AttendanceRecord::whereIn('subject_id', $subjectIds)
            ->where('date', '>=', now()->subDays(30))
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        $totalAtt = array_sum($attendanceData);
        $presentAtt = ($attendanceData['present'] ?? 0) + ($attendanceData['late'] ?? 0);
        $avgAttendance = $totalAtt > 0 ? round(($presentAtt / $totalAtt) * 100, 1) : 0;

        // Today's Classes
        $today = now()->format('l');
        $todayClasses = \App\Models\ClassSchedule::whereIn('subject_id', $subjectIds)
            ->where('day_of_week', $today)
            ->with('subject')
            ->orderBy('start_time')
            ->get();

        // Recent Activity
        $recentAttendance = AttendanceRecord::with(['student.user', 'subject'])
            ->whereIn('subject_id', $subjectIds)
            ->latest()
            ->take(5)
            ->get();

        $todayHoliday = \App\Models\Holiday::whereDate('date', today())->first();

        $recentGrades = Grade::with(['student.user', 'subject'])
            ->whereIn('subject_id', $subjectIds)
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'subjects', 
            'todayClasses', 
            'totalStudents', 
            'avgAttendance', 
            'recentAttendance', 
            'recentGrades',
            'todayHoliday'
        ));
    }

    /**
     * Student dashboard
     */
    protected function studentDashboard($user): View
    {
        $student = $user->student;
        
        if (!$student) {
            return view('student.dashboard', [
                'student' => null,
                'subjects' => collect(),
                'recentGrades' => collect(),
                'attendanceStats' => [],
                'todayClasses' => collect(),
                'todayHoliday' => \App\Models\Holiday::whereDate('date', today())->first(),
            ]);
        }

        $subjects = $student->subjects()->with(['teacher.user', 'classSchedules'])->get();
        $subjectIds = $subjects->pluck('id');
        
        $recentGrades = $student->grades()
            ->with('subject')
            ->latest()
            ->take(5)
            ->get();

        // Calculate attendance stats
        $totalRecords = $student->attendanceRecords()->count();
        $presentCount = $student->attendanceRecords()->where('status', 'present')->count();
        $lateCount = $student->attendanceRecords()->where('status', 'late')->count();
        $absentCount = $student->attendanceRecords()->where('status', 'absent')->count();

        $attendanceStats = [
            'total' => $totalRecords,
            'present' => $presentCount,
            'late' => $lateCount,
            'absent' => $absentCount,
            'percentage' => $totalRecords > 0 ? round((($presentCount + $lateCount) / $totalRecords) * 100, 1) : 0,
        ];

        // Fetch Today's Classes for Student
        $today = now()->format('l');
        $todayClasses = \App\Models\ClassSchedule::whereIn('subject_id', $subjectIds)
            ->where('day_of_week', $today)
            ->with('subject.teacher.user')
            ->orderBy('start_time')
            ->get();
        $todayHoliday = \App\Models\Holiday::whereDate('date', today())->first();

        return view('student.dashboard', compact('student', 'subjects', 'recentGrades', 'attendanceStats', 'todayClasses', 'todayHoliday'));
    }

    /**
     * Parent dashboard
     */
    protected function parentDashboard($user): View
    {
        $parent = $user->parentProfile;
        
        $students = $parent ? $parent->students()->with('user')->get() : collect();

        return view('parent.dashboard', compact('students'));
    }
}
