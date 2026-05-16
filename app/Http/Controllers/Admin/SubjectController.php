<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $subjects = Subject::with(['teacher.user', 'classSchedules'])->paginate(20);
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $teachers = Teacher::with('user')->get();
        $courses = \App\Models\Course::all();
        return view('admin.subjects.create', compact('teachers', 'courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:subjects'],
            'description' => ['nullable', 'string'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'year_level' => ['nullable', 'string', 'max:50'],
            'semester' => ['nullable', 'string', 'in:1st Semester,2nd Semester,Full Year'],
            'grade_level' => ['nullable', 'string', 'max:50'],
            'units' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
        ]);

        /* 
        if ($request->teacher_id) {
            $teacher = Teacher::find($request->teacher_id);
            if ($teacher->subjects()->count() >= 3) {
                return back()->withErrors(['teacher_id' => 'This teacher already has the maximum allowable subjects (3).'])->withInput();
            }
        }
        */

        $validated['is_active'] = $request->has('is_active');

        Subject::create($validated);

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject): View
    {
        $subject->load(['teacher.user', 'classSchedules', 'students.user']);
        return view('admin.subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject): View
    {
        $teachers = Teacher::with('user')->get();
        $students = Student::with('user')->get();
        $courses = \App\Models\Course::all();
        $enrolledStudentIds = $subject->students->pluck('id')->toArray();
        
        return view('admin.subjects.edit', compact('subject', 'teachers', 'students', 'enrolledStudentIds', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:20', 'unique:subjects,code,' . $subject->id],
            'description' => ['nullable', 'string'],
            'teacher_id' => ['nullable', 'exists:teachers,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'year_level' => ['nullable', 'string', 'max:50'],
            'semester' => ['nullable', 'string', 'in:1st Semester,2nd Semester,Full Year'],
            'grade_level' => ['nullable', 'string', 'max:50'],
            'units' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
            'student_ids' => ['nullable', 'array'],
            'student_ids.*' => ['exists:students,id'],
        ]);

        /*
        if ($request->teacher_id && $request->teacher_id != $subject->teacher_id) {
            $teacher = Teacher::find($request->teacher_id);
            if ($teacher->subjects()->count() >= 3) {
                return back()->withErrors(['teacher_id' => 'This teacher already has the maximum allowable subjects (3).'])->withInput();
            }
        }
        */

        $validated['is_active'] = $request->boolean('is_active');

        $subject->update($validated);

        // Sync students if provided
        if (isset($validated['student_ids'])) {
            $subject->students()->sync(
                collect($validated['student_ids'])->mapWithKeys(function ($id) {
                    return [$id => ['school_year' => date('Y'), 'is_active' => true]];
                })->toArray()
            );
        }

        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();
        
        return redirect()->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully!');
    }
}
