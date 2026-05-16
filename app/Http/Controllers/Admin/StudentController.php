<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\ParentModel;
use App\Models\QrCode;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $students = Student::with(['user', 'parent.user'])->paginate(20);
        return view('admin.students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $parents = ParentModel::with('user')->get();
        return view('admin.students.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'student_id_number' => ['required', 'string', 'max:50', 'unique:students'],
            'grade_level' => ['required', 'string', 'max:50'],
            'section' => ['required', 'string', 'max:50'],
            'parent_email' => ['required', 'email', 'max:255'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        // 1. Handle Student Account
        $studentTempPassword = \Illuminate\Support\Str::random(10);
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($studentTempPassword),
            'role' => 'student',
        ]);

        $student = Student::create([
            'user_id' => $user->id,
            'student_id_number' => $validated['student_id_number'],
            'grade_level' => $validated['grade_level'],
            'section' => $validated['section'],
            'birth_date' => $validated['birth_date'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
        ]);

        QrCode::generateForStudent($student);

        // Send Student Invitation
        \Illuminate\Support\Facades\Mail::to($validated['email'])->send(
            new \App\Mail\StudentInvitation([
                'student_name' => $validated['name'],
                'email' => $validated['email'],
                'temp_password' => $studentTempPassword,
                'student_id_number' => $validated['student_id_number']
            ])
        );

        // 2. Handle Parent Account
        $parentUser = User::where('email', $validated['parent_email'])->first();
        if (!$parentUser) {
            $parentTempPassword = \Illuminate\Support\Str::random(10);
            $parentUser = User::create([
                'name' => 'Parent of ' . $validated['name'],
                'email' => $validated['parent_email'],
                'password' => Hash::make($parentTempPassword),
                'role' => 'parent',
            ]);

            $parentProfile = ParentModel::create([
                'user_id' => $parentUser->id,
                'relationship' => 'Guardian',
                'notification_email' => $validated['parent_email'],
            ]);

            // Send Parent Invitation
            \Illuminate\Support\Facades\Mail::to($validated['parent_email'])->send(
                new \App\Mail\ParentInvitation([
                    'email' => $validated['parent_email'],
                    'temp_password' => $parentTempPassword
                ])
            );
        } else {
            $parentProfile = $parentUser->parentProfile;
        }

        if ($parentProfile) {
            $student->update(['parent_id' => $parentProfile->id]);
        }

        return redirect()->route('admin.students.index')
            ->with('success', 'Student and Parent accounts created. Invitations sent.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student): View
    {
        $student->load(['user', 'parent.user', 'qrCode', 'subjects', 'attendanceRecords', 'grades']);
        
        $weightedGrades = [];
        foreach ($student->subjects as $subject) {
            $weightedGrades[$subject->id] = \App\Models\Grade::calculateWeightedGrade($student->id, $subject->id);
        }

        return view('admin.students.show', compact('student', 'weightedGrades'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student): View
    {
        $parents = ParentModel::with('user')->get();
        return view('admin.students.edit', compact('student', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $student->user_id],
            'student_id_number' => ['required', 'string', 'max:50', 'unique:students,student_id_number,' . $student->id],
            'grade_level' => ['required', 'string', 'max:50'],
            'section' => ['required', 'string', 'max:50'],
            'parent_id' => ['nullable', 'exists:parents,id'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        // Update user
        $student->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update student
        $student->update([
            'student_id_number' => $validated['student_id_number'],
            'parent_id' => $validated['parent_id'],
            'grade_level' => $validated['grade_level'],
            'section' => $validated['section'],
            'birth_date' => $validated['birth_date'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student): RedirectResponse
    {
        $student->user->delete();
        
        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully!');
    }
}
