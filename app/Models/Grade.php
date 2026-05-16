<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'type',
        'title',
        'score',
        'total_score',
        'grading_period',
        'date_given',
        'remarks',
    ];

    protected $casts = [
        'score' => 'decimal:2',
        'total_score' => 'decimal:2',
        'date_given' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get percentage score
     */
    public function getPercentageAttribute(): float
    {
        if ($this->total_score == 0) {
            return 0;
        }
        return round(($this->score / $this->total_score) * 100, 2);
    }

    /**
     * Scope for specific grading period
     */
    public function scopeForPeriod($query, string $period)
    {
        return $query->where('grading_period', $period);
    }

    /**
     * Scope for specific type (quiz, oral, etc.)
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get grade types
     */
    public static function getTypes(): array
    {
        return ['quiz', 'oral', 'written', 'project', 'exam', 'assignment', 'participation'];
    }

    /**
     * Get grading periods
     */
    public static function getGradingPeriods(): array
    {
        return ['1st', '2nd', '3rd', '4th'];
    }
    /**
     * Calculate Weighted Final Grade for a student in a subject
     */
    public static function calculateWeightedGrade($studentId, $subjectId, $gradingPeriod = '1st')
    {
        $grades = self::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('grading_period', $gradingPeriod)
            ->get();

        // 1. Attendance (20%)
        $present = AttendanceRecord::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('status', 'present')
            ->count();
        $late = AttendanceRecord::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->where('status', 'late')
            ->count();
        $totalAttendance = AttendanceRecord::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->count();
        
        // Attendance score: Present + 0.5 * Late
        $attendanceScore = $totalAttendance > 0 ? (($present + ($late * 0.5)) / $totalAttendance) * 100 : 75; // Baseline 75 if no records
        $weightedAttendance = $attendanceScore * 0.20;

        // 2. Oral (20%)
        $oralGrades = $grades->where('type', 'oral');
        $oralScore = $oralGrades->count() > 0 ? ($oralGrades->sum('score') / $oralGrades->sum('total_score')) * 100 : 0;
        $weightedOral = $oralScore * 0.20;

        // 3. Quizzes (30%)
        $quizGrades = $grades->where('type', 'quiz');
        $quizScore = $quizGrades->count() > 0 ? ($quizGrades->sum('score') / $quizGrades->sum('total_score')) * 100 : 0;
        $weightedQuiz = $quizScore * 0.30;

        // 4. Exams (30%)
        $examGrades = $grades->where('type', 'exam');
        $examScore = $examGrades->count() > 0 ? ($examGrades->sum('score') / $examGrades->sum('total_score')) * 100 : 0;
        $weightedExam = $examScore * 0.30;

        $finalGrade = $weightedAttendance + $weightedOral + $weightedQuiz + $weightedExam;

        return [
            'attendance' => round($attendanceScore, 2),
            'oral' => round($oralScore, 2),
            'quiz' => round($quizScore, 2),
            'exam' => round($examScore, 2),
            'final' => round($finalGrade, 2),
            'weights' => [
                'attendance' => round($weightedAttendance, 2),
                'oral' => round($weightedOral, 2),
                'quiz' => round($weightedQuiz, 2),
                'exam' => round($weightedExam, 2),
            ]
        ];
    }
}
