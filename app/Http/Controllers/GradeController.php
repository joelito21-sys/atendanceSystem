<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GradeController extends Controller
{
    /**
     * Student view their grades
     */
    public function studentIndex(Request $request): View
    {
        $student = $request->user()->student;
        
        if (!$student) {
            return view('student.grades', [
                'subjects' => collect(),
                'grades' => collect(),
                'gradeSummary' => [],
            ]);
        }

        $subjects = $student->subjects;
        
        $query = $student->grades()->with('subject');

        if ($request->has('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('grading_period')) {
            $query->where('grading_period', $request->grading_period);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $grades = $query->orderBy('date_given', 'desc')->paginate(20);

        // New Weighted Calculation
        $weightedGrades = [];
        foreach ($subjects as $subject) {
            $weightedGrades[$subject->id] = Grade::calculateWeightedGrade($student->id, $subject->id);
        }

        return view('student.grades', compact('subjects', 'grades', 'weightedGrades'));
    }

    /**
     * Teacher view grades for their subjects
     */
    public function teacherIndex(Request $request): View
    {
        $teacher = $request->user()->teacher;
        
        if (!$teacher) {
            return view('teacher.grades.index', [
                'subjects' => collect(),
                'grades' => collect(),
            ]);
        }

        $subjects = $teacher->subjects;
        
        $query = Grade::with(['student.user', 'subject'])
            ->whereIn('subject_id', $subjects->pluck('id'));

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('grade_type') && $request->grade_type) {
            $query->where('grade_type', $request->grade_type);
        }

        if ($request->has('student_search') && $request->student_search) {
            $query->whereHas('student.user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student_search . '%');
            });
        }

        $grades = $query->orderBy('created_at', 'desc')->paginate(20);

        // If a subject is selected, calculate weighted grades for all students in that subject
        $weightedSummaries = [];
        if ($request->subject_id) {
            $subject = Subject::find($request->subject_id);
            if ($subject) {
                foreach ($subject->students as $student) {
                    $weightedSummaries[$student->id] = Grade::calculateWeightedGrade($student->id, $subject->id);
                }
            }
        }

        return view('teacher.grades.index', compact('subjects', 'grades', 'weightedSummaries'));
    }

    /**
     * Show form to add new grade
     */
    public function create(Request $request): View
    {
        $teacher = $request->user()->teacher;
        $subjects = $teacher ? $teacher->subjects : collect();
        
        // Get all students from teacher's subjects
        $students = Student::whereHas('subjects', function($query) use ($subjects) {
            $query->whereIn('subjects.id', $subjects->pluck('id'));
        })->with('user')->get();

        return view('teacher.grades.create', compact('subjects', 'students'));
    }

    /**
     * Store new grade
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|in:quiz,oral,exam,project,assignment,final',
            'title' => 'required|string|max:255',
            'score' => 'required|numeric|min:0',
            'total_score' => 'required|numeric|min:1',
            'grading_period' => 'required|in:1st,2nd,3rd,4th',
            'date_given' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        Grade::create($validated);

        return redirect()->route('teacher.grades.index')
            ->with('success', 'Grade record added successfully!');
    }

    /**
     * Show form to edit grade
     */
    public function edit(Grade $grade): View
    {
        return view('teacher.grades.edit', compact('grade'));
    }

    /**
     * Update grade
     */
    public function update(Request $request, Grade $grade): RedirectResponse
    {
        $validated = $request->validate([
            'type' => 'required|in:quiz,oral,exam,project,assignment,final',
            'title' => 'required|string|max:255',
            'score' => 'required|numeric|min:0',
            'total_score' => 'required|numeric|min:1',
            'grading_period' => 'required|in:1st,2nd,3rd,4th',
            'date_given' => 'required|date',
            'remarks' => 'nullable|string',
        ]);

        $grade->update($validated);

        return redirect()->route('teacher.grades.index')
            ->with('success', 'Grade updated successfully!');
    }

    /**
     * Delete grade
     */
    public function destroy(Grade $grade): RedirectResponse
    {
        $grade->delete();

        return redirect()->route('teacher.grades.index')
            ->with('success', 'Grade deleted successfully!');
    }

    /**
     * Bulk add grades for multiple students
     */
    public function bulkCreate(Request $request): View
    {
        $teacher = $request->user()->teacher;
        $subjects = $teacher ? $teacher->subjects : collect();
        
        $query = Student::query();

        if ($request->has('subject_id') && $request->subject_id) {
            $query->whereHas('subjects', function($q) use ($request) {
                $q->where('subjects.id', $request->subject_id);
            });
        } else {
            // Show nothing or all? Better show nothing until subject is selected for clarity
            $query->whereHas('subjects', function($q) use ($subjects) {
                $q->whereIn('subjects.id', $subjects->pluck('id'));
            });
        }

        $students = $query->with('user')->get();

        return view('teacher.grades.bulk-create', compact('subjects', 'students'));
    }

    /**
     * Store bulk grades
     */
    public function bulkStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|in:quiz,oral,exam,project,assignment,final',
            'title' => 'required|string|max:255',
            'total_score' => 'required|numeric|min:1',
            'grading_period' => 'required|in:1st,2nd,3rd,4th',
            'date_given' => 'required|date',
            'students' => 'required|array',
            'students.*.student_id' => 'required|exists:students,id',
            'students.*.score' => 'nullable|numeric|min:0',
            'students.*.remarks' => 'nullable|string',
        ]);

        $gradesAdded = 0;

        foreach ($validated['students'] as $studentData) {
            if (isset($studentData['score']) && $studentData['score'] !== null && $studentData['score'] !== '') {
                Grade::create([
                    'student_id' => $studentData['student_id'],
                    'subject_id' => $validated['subject_id'],
                    'type' => $validated['type'],
                    'title' => $validated['title'],
                    'score' => $studentData['score'],
                    'total_score' => $validated['total_score'],
                    'grading_period' => $validated['grading_period'],
                    'date_given' => $validated['date_given'],
                    'remarks' => $studentData['remarks'] ?? null,
                ]);
                $gradesAdded++;
            }
        }

        return redirect()->route('teacher.grades.index')
            ->with('success', "$gradesAdded grade record(s) added successfully!");
    }

    /**
     * Download CSV template for grade import
     */
    public function downloadTemplate(Request $request)
    {
        $subjectId = $request->query('subject_id');
        $subjectName = 'template';
        $students = collect();

        if ($subjectId) {
            $subject = Subject::find($subjectId);
            if ($subject) {
                $subjectName = str_replace(' ', '_', strtolower($subject->name));
                $students = $subject->students()->with('user')->get();
            }
        }

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"grade_import_{$subjectName}.csv\"",
        ];

        $callback = function() use ($students) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['student_id', 'student_name', 'score', 'remarks']);
            
            if ($students->count() > 0) {
                foreach ($students as $student) {
                    fputcsv($file, [
                        $student->student_id,
                        $student->user->name ?? 'N/A',
                        '', // Score placeholder
                        ''  // Remarks placeholder
                    ]);
                }
            } else {
                fputcsv($file, ['2024-0001', 'Sample Student', '95', 'Excellent']);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import grades from CSV
     */
    public function import(Request $request): RedirectResponse
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'type' => 'required|in:quiz,oral,exam,project,assignment,final',
            'title' => 'required|string|max:255',
            'total_score' => 'required|numeric|min:1',
            'grading_period' => 'required|in:1st,2nd,3rd,4th',
            'date_given' => 'required|date',
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        
        // Remove header row
        $header = array_shift($data);
        
        $gradesAdded = 0;
        $errors = [];

        foreach ($data as $row) {
            if (count($row) < 3) continue;

            $studentId = $row[0];
            $score = $row[2];
            $remarks = $row[3] ?? null;

            $student = Student::where('student_id', $studentId)->first();

            if ($student && is_numeric($score)) {
                Grade::create([
                    'student_id' => $student->id,
                    'subject_id' => $request->subject_id,
                    'type' => $request->type,
                    'title' => $request->title,
                    'score' => $score,
                    'total_score' => $request->total_score,
                    'grading_period' => $request->grading_period,
                    'date_given' => $request->date_given,
                    'remarks' => $remarks,
                ]);
                $gradesAdded++;
            } else {
                $errors[] = "Student ID $studentId not found or invalid score.";
            }
        }

        $message = "$gradesAdded grade records imported successfully!";
        if (!empty($errors)) {
            $message .= " Note: Some records failed: " . implode(', ', array_slice($errors, 0, 3));
        }

        return redirect()->route('teacher.grades.index')->with('success', $message);
    }
}
