<?php

namespace Tests\Feature;

use App\Models\PreEnrollment;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AutoEnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_is_automatically_enrolled_on_registration(): void
    {
        // 1. Setup: Create a subject
        $subject = Subject::create([
            'name' => 'Web Development',
            'code' => 'CS101',
            'units' => 3,
            'is_active' => true,
        ]);

        // 2. Setup: Add to Master Enrollment List
        PreEnrollment::create([
            'student_id_number' => 'STU-001',
            'subject_code' => 'CS101',
            'school_year' => '2025-2026',
            'semester' => '1st',
        ]);

        // 3. Action: Register a student with the matching ID
        $response = $this->post('/register', [
            'name' => 'Auto Enrolled Student',
            'email' => 'auto@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'student',
            'student_id_number' => 'STU-001',
            'grade_level' => '10',
            'section' => 'A',
        ]);

        // 4. Verification
        $this->assertAuthenticated();
        
        $user = User::where('email', 'auto@example.com')->first();
        $student = $user->student;

        // Check if student is enrolled in the subject
        $this->assertTrue($student->subjects->contains($subject));
        $this->assertEquals('2025-2026', $student->subjects->first()->pivot->school_year);
    }
}
