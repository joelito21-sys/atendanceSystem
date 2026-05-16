<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class QrCodeController extends Controller
{
    /**
     * Show QR code for a student
     */
    public function show(Request $request): View
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return view('student.qr-code', ['qrCode' => null]);
        }

        // Get or generate QR code
        $qrCode = $student->qrCode;
        
        if (!$qrCode || !$qrCode->is_active) {
            $qrCode = QrCode::generateForStudent($student);
        }

        return view('student.qr-code', compact('qrCode', 'student'));
    }

    /**
     * Generate new QR code for a student
     */
    public function generate(Request $request): JsonResponse
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Student profile not found.',
            ], 400);
        }

        $qrCode = QrCode::generateForStudent($student);

        return response()->json([
            'success' => true,
            'message' => 'New QR code generated successfully!',
            'qr_code' => $qrCode->code,
            'data_uri' => $qrCode->getDataUri(),
        ]);
    }

    /**
     * Admin: Generate QR codes for all students
     */
    public function generateAll(): JsonResponse
    {
        $students = Student::all();
        $generated = 0;

        foreach ($students as $student) {
            if (!$student->qrCode || !$student->qrCode->is_active) {
                QrCode::generateForStudent($student);
                $generated++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Generated QR codes for {$generated} students.",
        ]);
    }

    /**
     * Admin: Show QR code for specific student
     */
    public function adminShow(Student $student): View
    {
        $qrCode = $student->qrCode;
        
        if (!$qrCode || !$qrCode->is_active) {
            $qrCode = QrCode::generateForStudent($student);
        }

        return view('admin.students.qr-code', compact('qrCode', 'student'));
    }

    /**
     * Verify QR code (for testing)
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $qrCode = QrCode::where('code', $request->code)
            ->where('is_active', true)
            ->with('student.user')
            ->first();

        if (!$qrCode) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or inactive QR code.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'student' => [
                'id' => $qrCode->student->id,
                'name' => $qrCode->student->user->name,
                'student_id' => $qrCode->student->student_id_number,
                'grade_level' => $qrCode->student->grade_level,
                'section' => $qrCode->student->section,
            ],
        ]);
    }
}
