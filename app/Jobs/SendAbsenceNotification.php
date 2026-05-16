<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\CustomNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAbsenceNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $student;
    protected $date;

    /**
     * Create a new job instance.
     */
    public function __construct(Student $student, $date)
    {
        $this->student = $student;
        $this->date = $date;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Logic to send email/notification to parent
            $parent = $this->student->parent;
            
            if ($parent && $parent->user) {
                // 1. Create in-app notification
                CustomNotification::create([
                    'user_id' => $parent->user->id,
                    'title' => 'Absence Alert',
                    'message' => "Your child {$this->student->first_name} was marked absent on {$this->date}.",
                    'type' => 'warning',
                    'link' => route('parent.child.attendance', $this->student->id),
                ]);

                // 2. Send Email (simulated for now, or actual if mail is configured)
                // Mail::to($parent->user->email)->send(new AbsenceAlert($this->student, $this->date));
                
                Log::info("Absence notification sent for student {$this->student->id} to parent {$parent->id}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to send absence notification: " . $e->getMessage());
        }
    }
}
