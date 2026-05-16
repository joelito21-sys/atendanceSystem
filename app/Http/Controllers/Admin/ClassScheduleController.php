<?php

namespace App\Http\Controllers\Admin;

use App\Models\ClassSchedule;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class ClassScheduleController extends Controller
{
    /**
     * Display a listing of class schedules
     */
    public function index(Request $request): View
    {
        $query = ClassSchedule::with(['subject', 'teacher']);

        if ($request->has('subject_id') && $request->subject_id) {
            $query->where('subject_id', $request->subject_id);
        }

        if ($request->has('day') && $request->day) {
            $query->where('day_of_week', $request->day);
        }

        $schedules = $query->orderBy('day_of_week')->orderBy('start_time')->paginate(20);
        $subjects = Subject::all();

        return view('admin.schedules.index', compact('schedules', 'subjects'));
    }

    /**
     * Show the form for creating a new schedule
     */
    public function create(): View
    {
        $subjects = Subject::with('teacher')->get();
        $teachers = Teacher::with('user')->get();

        return view('admin.schedules.create', compact('subjects', 'teachers'));
    }

    /**
     * Store a newly created schedule
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'required|string|max:50',
            'section' => 'required|string|max:50',
        ]);

        // Check for conflicts
        $conflict = $this->checkConflict(
            $validated['subject_id'],
            $validated['day_of_week'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['room'],
            $validated['section']
        );

        if ($conflict) {
            return back()
                ->withErrors(['conflict' => $conflict])
                ->withInput();
        }

        ClassSchedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Class schedule created successfully!');
    }

    /**
     * Display the specified schedule
     */
    public function show(ClassSchedule $schedule): View
    {
        $schedule->load(['subject.teacher.user']);
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified schedule
     */
    public function edit(ClassSchedule $schedule): View
    {
        $subjects = Subject::with('teacher')->get();
        // $teachers is no longer needed in the form if it's tied to subject
        return view('admin.schedules.edit', compact('schedule', 'subjects'));
    }

    /**
     * Update the specified schedule
     */
    public function update(Request $request, ClassSchedule $schedule): RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'day_of_week' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'required|string|max:50',
            'section' => 'required|string|max:50',
        ]);

        // Check for conflicts
        $conflict = $this->checkConflict(
            $validated['subject_id'],
            $validated['day_of_week'],
            $validated['start_time'],
            $validated['end_time'],
            $validated['room'],
            $validated['section'],
            $schedule->id
        );

        if ($conflict) {
            return back()
                ->withErrors(['conflict' => $conflict])
                ->withInput();
        }

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Class schedule updated successfully!');
    }

    /**
     * Remove the specified schedule
     */
    public function destroy(ClassSchedule $schedule): RedirectResponse
    {
        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Class schedule deleted successfully!');
    }

    /**
     * Check for schedule conflicts (Room, Teacher, and Section)
     * Returns error message if conflict exists, null otherwise
     */
    private function checkConflict($subjectId, $day, $startTime, $endTime, $room, $section, $excludeId = null)
    {
        $subject = Subject::find($subjectId);
        $teacherId = $subject->teacher_id;

        // 1. Check for Room Conflict
        $roomConflict = ClassSchedule::where('day_of_week', $day)
            ->where('room', $room)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q2) use ($startTime, $endTime) {
                        $q2->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->first();

        if ($roomConflict) {
            return "Room Conflict: Room {$room} is already booked by {$roomConflict->subject->name} at this time.";
        }

        // 2. Check for Teacher Conflict
        $teacherConflict = ClassSchedule::where('day_of_week', $day)
            ->whereHas('subject', function($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q2) use ($startTime, $endTime) {
                        $q2->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->first();

        if ($teacherConflict) {
            return "Teacher Conflict: The teacher is already teaching {$teacherConflict->subject->name} during this time.";
        }

        // 3. Check for Section Conflict
        $sectionConflict = ClassSchedule::where('day_of_week', $day)
            ->where('section', $section)
            ->where(function ($q) use ($startTime, $endTime) {
                $q->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q2) use ($startTime, $endTime) {
                        $q2->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->when($excludeId, fn($q) => $q->where('id', '!=', $excludeId))
            ->first();

        if ($sectionConflict) {
            return "Section Conflict: Section {$section} already has a class ({$sectionConflict->subject->name}) at this time.";
        }

        return null;
    }
}
