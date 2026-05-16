<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceRecord extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'class_schedule_id',
        'date',
        'time_in',
        'time_out',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime:H:i:s',
        'time_out' => 'datetime:H:i:s',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function classSchedule(): BelongsTo
    {
        return $this->belongsTo(ClassSchedule::class);
    }

    /**
     * Check if student is late based on class schedule
     */
    public function calculateStatus(): string
    {
        if (!$this->time_in) {
            return 'absent';
        }

        if ($this->classSchedule) {
            $scheduleStart = $this->classSchedule->start_time;
            $graceMinutes = 15; // 15 minutes grace period
            
            $timeIn = \Carbon\Carbon::parse($this->time_in);
            $lateThreshold = \Carbon\Carbon::parse($scheduleStart)->addMinutes($graceMinutes);
            
            if ($timeIn->gt($lateThreshold)) {
                return 'late';
            }
        }

        return 'present';
    }

    /**
     * Scope for today's attendance
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }

    /**
     * Scope for a specific subject
     */
    public function scopeForSubject($query, $subjectId)
    {
        return $query->where('subject_id', $subjectId);
    }
}
