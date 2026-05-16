<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PreEnrollment;
use App\Models\Subject;
use App\Mail\EnrollmentNotification;
use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PreEnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $query = PreEnrollment::query();

        if ($user->role === 'teacher') {
            $teacherSubjects = $user->teacher->subjects->pluck('code')->toArray();
            $query->whereIn('subject_code', $teacherSubjects);
        }

        $preEnrollments = $query->select('student_id_number', 'student_name')
            ->selectRaw('MAX(id) as id')
            ->selectRaw('COUNT(*) as subjects_count')
            ->groupBy('student_id_number', 'student_name')
            ->orderByDesc('id')
            ->paginate(20);
        return view('admin.pre-enrollments.index', compact('preEnrollments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $user = $request->user();
        
        if ($user->role === 'teacher') {
            $courses = \App\Models\Course::whereHas('subjects', function($q) use ($user) {
                $q->where('teacher_id', $user->teacher->id);
            })->get();
        } else {
            $courses = \App\Models\Course::all();
        }

        return view('admin.pre-enrollments.create', compact('courses'));
    }

    /**
     * Get subjects based on curriculum filters (AJAX).
     */
    public function getSubjects(Request $request)
    {
        $user = $request->user();
        $query = Subject::where('course_id', $request->course_id)
            ->where('year_level', $request->year_level)
            ->where('semester', $request->semester);

        if ($user->role === 'teacher') {
            $query->where('teacher_id', $user->teacher->id);
        }

        $subjects = $query->get();

        return response()->json($subjects);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id_number' => 'required|string|max:255',
            'student_name' => 'required|string|max:255',
            'student_email' => 'required|email|max:255',
            'parent_email' => 'required|email|max:255',
            'subject_codes' => 'required|array',
            'subject_codes.*' => 'string|exists:subjects,code',
            'section' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'school_year' => 'required|string|max:255',
            'semester' => ['required', 'string', \Illuminate\Validation\Rule::in(['1st Semester', '2nd Semester', 'Summer'])],
        ]);

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($validated) {
                $studentTempPassword = null;
                $parentTempPassword = null;
                $wasNewStudent = false;
                $wasNewParent = false;

                // 1. Handle Student Account Creation
                $studentUser = \App\Models\User::where('email', $validated['student_email'])->first();
                $student = \App\Models\Student::where('student_id_number', $validated['student_id_number'])->first();

                // Validation: Consistency Check
                if ($studentUser) {
                    // Email exists, check role
                    if (!$studentUser->isStudent()) {
                        throw new \Exception('The email '.$validated['student_email'].' is already registered to a non-student account.');
                    }
                    // Email exists, check Name (Case-insensitive check for better UX)
                    if (strcasecmp($studentUser->name, $validated['student_name']) !== 0) {
                        throw new \Exception('The email '.$validated['student_email'].' is already registered to Student "'.$studentUser->name.'". Please use the same name.');
                    }
                    // Email exists, check ID
                    if ($studentUser->student && $studentUser->student->student_id_number !== $validated['student_id_number']) {
                        throw new \Exception('This email is already linked to Student ID: '.$studentUser->student->student_id_number.'. Please check the ID number.');
                    }
                }

                if ($student) {
                    // ID exists, check for Email consistency
                    if ($student->user->email !== $validated['student_email']) {
                        throw new \Exception('Student ID '.$validated['student_id_number'].' is already registered to a different email ('.$student->user->email.').');
                    }
                    // ID exists, check for Name consistency
                    if (strcasecmp($student->user->name, $validated['student_name']) !== 0) {
                        throw new \Exception('Student ID '.$validated['student_id_number'].' is already assigned to Name: "'.$student->user->name.'".');
                    }
                }


                // Create User if doesn't exist
                if (!$studentUser) {
                    $wasNewStudent = true;
                    $studentTempPassword = \Illuminate\Support\Str::random(10);
                    $studentUser = \App\Models\User::create([
                        'name' => $validated['student_name'],
                        'email' => $validated['student_email'],
                        'password' => \Illuminate\Support\Facades\Hash::make($studentTempPassword),
                        'role' => 'student',
                    ]);
                }

                // Create Student Profile if doesn't exist
                if (!$student) {
                    $student = \App\Models\Student::create([
                        'user_id' => $studentUser->id,
                        'student_id_number' => $validated['student_id_number'],
                        'section' => $validated['section'],
                        'grade_level' => $validated['year_level'],
                    ]);
                }

                // 2. Handle Parent Account Creation
                $parentUser = \App\Models\User::where('email', $validated['parent_email'])->first();
                if ($parentUser && !$parentUser->isParent()) {
                     throw new \Exception('The parent email is already registered to a non-parent account.');
                }

                if (!$parentUser) {
                    $wasNewParent = true;
                    $parentTempPassword = \Illuminate\Support\Str::random(10);
                    $parentUser = \App\Models\User::create([
                        'name' => 'Parent of ' . $validated['student_name'],
                        'email' => $validated['parent_email'],
                        'password' => \Illuminate\Support\Facades\Hash::make($parentTempPassword),
                        'role' => 'parent',
                    ]);

                    \App\Models\ParentModel::create([
                        'user_id' => $parentUser->id,
                        'relationship' => 'Guardian',
                        'notification_email' => $validated['parent_email'],
                    ]);
                }

                // Link student to parent if not already linked
                if ($student && !$student->parent_id && $parentUser->parentProfile) {
                    $student->update(['parent_id' => $parentUser->parentProfile->id]);
                }

                // 3. Create Pre-Enrollment Rules and Enroll in Subjects
                $enrolledSubjects = [];
                foreach ($validated['subject_codes'] as $code) {
                    $subject = Subject::where('code', $code)->first();
                    if ($subject) {
                        $enrolledSubjects[] = $subject;
                    }

                    // Prevent duplicate pre-enrollment entries
                    $exists = PreEnrollment::where('student_id_number', $validated['student_id_number'])
                        ->where('subject_code', $code)
                        ->where('school_year', $validated['school_year'])
                        ->where('semester', $validated['semester'])
                        ->exists();

                    if (!$exists) {
                        PreEnrollment::create([
                            'student_id_number' => $validated['student_id_number'],
                            'student_name' => $validated['student_name'],
                            'student_email' => $validated['student_email'],
                            'parent_email' => $validated['parent_email'],
                            'subject_code' => $code,
                            'section' => $validated['section'],
                            'school_year' => $validated['school_year'],
                            'semester' => $validated['semester'],
                        ]);
                    }

                    // Enroll student immediately
                    if ($subject && !$student->subjects()->where('subject_id', $subject->id)->exists()) {
                        $student->subjects()->attach($subject->id, [
                            'school_year' => $validated['school_year'],
                            'semester' => $validated['semester'],
                            'is_active' => true,
                        ]);
                    }
                }

                // 4. Send Notifications
                if ($wasNewStudent) {
                    \Illuminate\Support\Facades\Mail::to($validated['student_email'])->send(
                        new \App\Mail\StudentInvitation([
                            'student_name' => $validated['student_name'],
                            'email' => $validated['student_email'],
                            'temp_password' => $studentTempPassword,
                            'student_id_number' => $validated['student_id_number']
                        ])
                    );
                } else {
                    \Illuminate\Support\Facades\Mail::to($validated['student_email'])->send(
                        new \App\Mail\EnrollmentNotification([
                            'student_name' => $validated['student_name'],
                            'school_year' => $validated['school_year'],
                            'semester' => $validated['semester'],
                            'subjects' => $enrolledSubjects
                        ])
                    );
                }

                if ($wasNewParent) {
                    \Illuminate\Support\Facades\Mail::to($validated['parent_email'])->send(
                        new \App\Mail\ParentInvitation([
                            'email' => $validated['parent_email'],
                            'temp_password' => $parentTempPassword
                        ])
                    );
                }
            });


            $redirectRoute = auth()->user()->role === 'admin' ? 'admin.pre-enrollments.index' : 'teacher.pre-enrollments.index';


            return redirect()->route($redirectRoute)
                ->with('success', 'Accounts created/found and subjects enrolled. Invitations sent.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Enrollment failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PreEnrollment $preEnrollment): View
    {
        $studentEnrollments = PreEnrollment::where('student_id_number', $preEnrollment->student_id_number)
            ->latest()
            ->get();
            
        return view('admin.pre-enrollments.show', compact('preEnrollment', 'studentEnrollments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PreEnrollment $preEnrollment): View
    {
        $subjects = Subject::all();
        return view('admin.pre-enrollments.edit', compact('preEnrollment', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PreEnrollment $preEnrollment): RedirectResponse
    {
        $validated = $request->validate([
            'student_id_number' => 'required|string|max:255',
            'subject_code' => 'required|string|exists:subjects,code',
            'section' => 'nullable|string|max:255',
            'school_year' => 'required|string|max:255',
            'semester' => 'required|in:1st,2nd,full_year',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($validated, $preEnrollment) {
            $preEnrollment->update($validated);

            // Sync with actual student enrollment
            $student = \App\Models\Student::where('student_id_number', $validated['student_id_number'])->first();
            if ($student) {
                $subject = Subject::where('code', $validated['subject_code'])->first();
                if ($subject) {
                    // Update or Attach to pivot table
                    $student->subjects()->syncWithoutDetaching([
                        $subject->id => [
                            'school_year' => $validated['school_year'],
                            'semester' => $validated['semester'],
                            'is_active' => true,
                        ]
                    ]);
                }
            }
        });

        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.pre-enrollments.index' : 'teacher.pre-enrollments.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Master Enrollment List and Student Record updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PreEnrollment $preEnrollment): RedirectResponse
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($preEnrollment) {
            // Also remove from actual enrollment if this was the last entry for this subject/student
            $student = \App\Models\Student::where('student_id_number', $preEnrollment->student_id_number)->first();
            $subject = Subject::where('code', $preEnrollment->subject_code)->first();
            
            $preEnrollment->delete();

            if ($student && $subject) {
                // Only detach if no more pre-enrollment entries exist for this student and subject
                $stillExists = PreEnrollment::where('student_id_number', $student->student_id_number)
                    ->where('subject_code', $subject->code)
                    ->exists();
                
                if (!$stillExists) {
                    $student->subjects()->detach($subject->id);
                }
            }
        });

        $redirectRoute = auth()->user()->role === 'admin' ? 'admin.pre-enrollments.index' : 'teacher.pre-enrollments.index';

        return redirect()->route($redirectRoute)
            ->with('success', 'Entry removed from Master Enrollment List and Student Record.');
    }

    /**
     * Sync all students' enrollment based on pre-enrollment rules.
     */
    public function syncAll(): RedirectResponse
    {
        $preEnrollments = PreEnrollment::all();
        $syncedCount = 0;

        foreach ($preEnrollments as $pe) {
            $student = \App\Models\Student::where('student_id_number', $pe->student_id_number)->first();
            $subject = Subject::where('code', $pe->subject_code)->first();

            if ($student && $subject) {
                if (!$student->subjects()->where('subject_id', $subject->id)->exists()) {
                    $student->subjects()->attach($subject->id, [
                        'school_year' => $pe->school_year,
                        'semester' => $pe->semester,
                        'is_active' => true,
                    ]);
                    $syncedCount++;
                }
            }
        }

        return back()->with('success', "Synchronization complete. $syncedCount new subjects enrolled across all students.");
    }
}
