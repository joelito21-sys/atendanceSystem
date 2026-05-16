<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\Subject;
use App\Models\EmailLog;
use App\Mail\AttendanceNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendAttendanceNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Student $student;
    public string $type;
    public ?Subject $subject;
    public Carbon $timestamp;

    /**
     * Create a new job instance.
     */
    public function __construct(Student $student, string $type, ?Subject $subject, Carbon $timestamp)
    {
        $this->student = $student;
        $this->type = $type;
        $this->subject = $subject;
        $this->timestamp = $timestamp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $parent = $this->student->parent;

        if (!$parent || !$parent->receive_notifications) {
            return;
        }

        $recipientEmail = $parent->notification_email;

        // Create email log
        $emailLog = EmailLog::create([
            'student_id' => $this->student->id,
            'parent_id' => $parent->id,
            'type' => $this->type,
            'subject' => $this->getSubjectLine(),
            'recipient_email' => $recipientEmail,
            'status' => 'pending',
        ]);

        try {
            Mail::to($recipientEmail)->send(
                new AttendanceNotification(
                    $this->student,
                    $this->type,
                    $this->subject,
                    $this->timestamp
                )
            );

            $emailLog->markAsSent();
        } catch (\Exception $e) {
            $emailLog->markAsFailed($e->getMessage());
        }
    }

    /**
     * Get subject line for email log
     */
    protected function getSubjectLine(): string
    {
        return match($this->type) {
            'time_in' => "Attendance: {$this->student->user->name} has arrived",
            'time_out' => "Attendance: {$this->student->user->name} has left",
            'absent' => "Attendance: {$this->student->user->name} was marked absent",
            'late' => "Attendance: {$this->student->user->name} arrived late",
            default => "Attendance Update for {$this->student->user->name}",
        };
    }
}
