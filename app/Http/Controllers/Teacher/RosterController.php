<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RosterController extends Controller
{
    /**
     * Display a listing of students enrolled in the teacher's subjects.
     */
    public function index(Request $request): View
    {
        $teacher = $request->user()->teacher;
        
        if (!$teacher) {
            return view('teacher.roster.index', ['students' => collect(), 'subjects' => collect()]);
        }

        $subjects = $teacher->subjects()->with('students.user')->get();
        
        // Flatten students from all subjects and make unique
        $students = $subjects->pluck('students')->flatten()->unique('id');

        return view('teacher.roster.index', compact('students', 'subjects'));
    }

    /**
     * Show students for a specific subject.
     */
    public function subjectRoster(Request $request, $subjectId): View
    {
        $teacher = $request->user()->teacher;
        $subject = $teacher->subjects()->with('students.user')->findOrFail($subjectId);
        $students = $subject->students;

        return view('teacher.roster.subject', compact('subject', 'students'));
    }
}
