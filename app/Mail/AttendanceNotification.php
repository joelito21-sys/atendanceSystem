<?php

namespace App\Mail;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class AttendanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public Student $student;
    public string $type;
    public ?Subject $subject;
    public Carbon $timestamp;

    /**
     * Create a new message instance.
     */
    public function __construct(Student $student, string $type, ?Subject $subject, Carbon $timestamp)
    {
        $this->student = $student;
        $this->type = $type;
        $this->subject = $subject;
        $this->timestamp = $timestamp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subjectLine = match($this->type) {
            'time_in' => "Attendance: {$this->student->user->name} has arrived",
            'time_out' => "Attendance: {$this->student->user->name} has left",
            'absent' => "Attendance: {$this->student->user->name} was marked absent",
            'late' => "Attendance: {$this->student->user->name} arrived late",
            default => "Attendance Update for {$this->student->user->name}",
        };

        return new Envelope(
            subject: $subjectLine,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.attendance-notification',
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        return [];
    }
}
