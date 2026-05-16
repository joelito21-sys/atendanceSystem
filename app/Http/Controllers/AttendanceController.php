<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Subject;
use App\Models\AttendanceRecord;
use App\Models\QrCode;
use App\Jobs\SendAttendanceNotification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\ClassSchedule;

class AttendanceController extends Controller
{
    /**
     * Show attendance scanner interface
     */
    public function scanner(): View
    {
        $subjects = Subject::with('teacher.user')->where('is_active', true)->get();
        return view('teacher.scanner', compact('subjects'));
    }

    /**
     * Process scanned QR code - Time In
     */
    public function timeIn(Request $request): JsonResponse
    {
        $request->validate([
            'qr_code' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $qrCode = QrCode::where('code', $request->qr_code)
            ->where('is_active', true)
            ->first();

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive QR code.',
            ], 400);
        }

        $student = $qrCode->student;
        $subject = Subject::find($request->subject_id);

        // Check if already timed in today for this subject
        $existingRecord = AttendanceRecord::where('student_id', $student->id)
            ->where('subject_id', $request->subject_id)
            ->whereDate('date', today())
            ->first();

        if ($existingRecord && $existingRecord->time_in) {
            return response()->json([
                'success' => false,
                'message' => 'Student already timed in for this subject today.',
                'student_name' => $student->user->name,
                'time_in' => $existingRecord->time_in,
            ], 400);
        }

        $now = Carbon::now();
        
        // Create or update attendance record
        $attendance = AttendanceRecord::updateOrCreate(
            [
                'student_id' => $student->id,
                'subject_id' => $request->subject_id,
                'date' => today(),
            ],
            [
                'time_in' => $now->format('H:i:s'),
                'status' => 'present', // Will be recalculated
            ]
        );

        // Calculate status based on schedule
        $attendance->status = $attendance->calculateStatus();
        $attendance->save();

        // Dispatch email notification to parent
        if ($student->parent && $student->parent->receive_notifications) {
            SendAttendanceNotification::dispatch($student, 'time_in', $subject, $now);
        }

        return response()->json([
            'success' => true,
            'message' => 'Time in recorded successfully!',
            'student_name' => $student->user->name,
            'student_id' => $student->student_id_number,
            'subject' => $subject->name,
            'time_in' => $now->format('h:i A'),
            'status' => $attendance->status,
        ]);
    }

    /**
     * Process scanned QR code - Time Out
     */
    public function timeOut(Request $request): JsonResponse
    {
        $request->validate([
            'qr_code' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $qrCode = QrCode::where('code', $request->qr_code)
            ->where('is_active', true)
            ->first();

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive QR code.',
            ], 400);
        }

        $student = $qrCode->student;
        $subject = Subject::find($request->subject_id);

        // Find today's attendance record
        $attendance = AttendanceRecord::where('student_id', $student->id)
            ->where('subject_id', $request->subject_id)
            ->whereDate('date', today())
            ->first();

        if (!$attendance || !$attendance->time_in) {
            return response()->json([
                'success' => false,
                'message' => 'No time in record found for today.',
            ], 400);
        }

        if ($attendance->time_out) {
            return response()->json([
                'success' => false,
                'message' => 'Student already timed out for this subject today.',
            ], 400);
        }

        $now = Carbon::now();
        $attendance->update(['time_out' => $now->format('H:i:s')]);

        // Dispatch email notification to parent
        if ($student->parent && $student->parent->receive_notifications) {
            SendAttendanceNotification::dispatch($student, 'time_out', $subject, $now);
        }

        return response()->json([
            'success' => true,
            'message' => 'Time out recorded successfully!',
            'student_name' => $student->user->name,
            'student_id' => $student->student_id_number,
            'subject' => $subject->name,
            'time_out' => $now->format('h:i A'),
        ]);
    }

    /**
     * Process scanned QR code - Automatic
     */
    public function process(Request $request): JsonResponse
    {
        $request->validate([
            'qr_code' => 'required|string',
            'subject_id' => 'nullable|exists:subjects,id',
        ]);

        $qrCode = QrCode::where('code', $request->qr_code)
            ->where('is_active', true)
            ->first();

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive QR code.',
            ], 400);
        }

        $student = $qrCode->student;
        $now = Carbon::now();
        $subjectId = $request->subject_id;
        $schedule = null;

        // Auto-detect subject if not provided
        if (!$subjectId) {
            // Find a schedule for today and current time
            // We need to check if the student is enrolled in the subject
            // and if there is a class schedule for that subject at this time
            
            $dayOfWeek = strtolower($now->format('l')); // Monday, Tuesday...

            $schedule = ClassSchedule::whereHas('subject', function($query) use ($student) {
                    $query->whereHas('students', function($q) use ($student) {
                        $q->where('students.id', $student->id);
                    });
                })
                ->where('day_of_week', $dayOfWeek)
                ->where('start_time', '<=', $now->format('H:i:s'))
                ->where('end_time', '>=', $now->format('H:i:s'))
                ->first();

            if ($schedule) {
                $subjectId = $schedule->subject_id;
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No class schedule found for this student at this day and time.',
                ], 400);
            }
        }

        $subject = Subject::find($subjectId);

        // Check if student is enrolled in this subject (double check for manual selection)
        if (!$student->subjects()->where('subjects.id', $subjectId)->exists()) {
             return response()->json([
                'success' => false,
                'message' => 'Student is not enrolled in this subject.',
            ], 400);
        }

        // Determine Action: Time In or Time Out
        $existingRecord = AttendanceRecord::where('student_id', $student->id)
            ->where('subject_id', $subjectId)
            ->whereDate('date', today())
            ->first();

        if (!$existingRecord) {
            // TIME IN
            $attendance = AttendanceRecord::create([
                'student_id' => $student->id,
                'subject_id' => $subjectId,
                'class_schedule_id' => $schedule ? $schedule->id : null,
                'date' => today(),
                'time_in' => $now->format('H:i:s'),
                'status' => 'present', 
            ]);

            // Calculate status
            $attendance->status = $attendance->calculateStatus();
            $attendance->save();

            // Notify
            if ($student->parent && $student->parent->receive_notifications) {
                SendAttendanceNotification::dispatch($student, 'time_in', $subject, $now);
            }

            return response()->json([
                'success' => true,
                'message' => 'Time In recorded!',
                'type' => 'time-in',
                'student_name' => $student->user->name,
                'student_id' => $student->student_id_number,
                'subject' => $subject->name,
                'time_in' => $now->format('h:i A'),
                'status' => $attendance->status,
            ]);
        } elseif (!$existingRecord->time_out) {
            // TIME OUT
            $existingRecord->update(['time_out' => $now->format('H:i:s')]);
            
            // Notify
            if ($student->parent && $student->parent->receive_notifications) {
                SendAttendanceNotification::dispatch($student, 'time_out', $subject, $now);
            }

            return response()->json([
                'success' => true,
                'message' => 'Time Out recorded!',
                'type' => 'time-out',
                'student_name' => $student->user->name,
                'student_id' => $student->student_id_number,
                'subject' => $subject->name,
                'time_out' => $now->format('h:i A'),
            ]);
        } else {
            // ALREADY COMPLETED
            return response()->json([
                'success' => false,
                'message' => 'Attendance already completed for this subject today.',
                'student_name' => $student->user->name,
                'time_in' => $existingRecord->time_in ? Carbon::parse($existingRecord->time_in)->format('h:i A') : 'N/A',
                'time_out' => $existingRecord->time_out ? Carbon::parse($existingRecord->time_out)->format('h:i A') : 'N/A',
            ], 400);
        }
    }

    /**
     * Show attendance records for a subject
     */
    public function index(Request $request): View
    {
        $user = auth()->user();
        $query = AttendanceRecord::with(['student.user', 'subject']);

        if ($user->role === 'teacher') {
            $teacher = $user->teacher;
            $teacherSubjectIds = $teacher ? $teacher->subjects->pluck('id') : collect();
            $query->whereIn('subject_id', $teacherSubjectIds);
            $subjects = $teacher ? $teacher->subjects : collect();
        } else {
            $subjects = Subject::where('is_active', true)->get();
        }

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', today());
        }

        $attendance = $query->orderBy('time_in', 'desc')->paginate(20);

        return view('teacher.attendance', compact('attendance', 'subjects'));
    }

    /**
     * Student view their own attendance
     */
    /**
     * Student view their own attendance
     */
    public function studentIndex(Request $request, Student $student = null): View
    {
        // If no student provided, try to get from current user
        if (!$student) {
            $student = $request->user()->student;
        }

        // If still no student (e.g. admin without param), show empty or error
        if (!$student) {
            // If admin, maybe redirect or show message
            if ($request->user()->role === 'admin') {
                return view('student.attendance', [
                    'attendance' => collect(),
                    'subjects' => collect(),
                    'stats' => [],
                    'isAdminPreview' => true
                ]);
            }
            
            return view('student.attendance', [
                'attendance' => collect(),
                'subjects' => collect(),
                'stats' => [],
            ]);
        }

        $query = $student->attendanceRecords()->with('subject');

        if ($request->has('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        $attendance = $query->orderBy('date', 'desc')->paginate(20);
        $subjects = $student->subjects;

        // Calculate stats per subject
        $stats = [];
        foreach ($subjects as $subject) {
            $subjectRecords = $student->attendanceRecords()->where('subject_id', $subject->id);
            $total = $subjectRecords->count();
            $present = (clone $subjectRecords)->where('status', 'present')->count();
            $late = (clone $subjectRecords)->where('status', 'late')->count();
            
            $stats[$subject->id] = [
                'total' => $total,
                'present' => $present,
                'late' => $late,
                'absent' => $total - $present - $late,
                'percentage' => $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0,
            ];
        }

        return view('student.attendance', compact('attendance', 'subjects', 'stats'));
    }
}
