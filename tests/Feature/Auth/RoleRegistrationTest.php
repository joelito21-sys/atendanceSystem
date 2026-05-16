<?php

namespace Tests\Feature\Auth;

use App\Models\ParentModel;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_register_with_profile(): void
    {
        $response = $this->post('/register', [
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'student',
            'student_id_number' => 'STU001',
            'grade_level' => 'Grade 10',
            'section' => 'A',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'student@example.com')->first();
        $this->assertEquals('student', $user->role);
        
        $this->assertDatabaseHas('students', [
            'user_id' => $user->id,
            'student_id_number' => 'STU001',
            'grade_level' => 'Grade 10',
            'section' => 'A',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_teacher_can_register_with_profile(): void
    {
        $response = $this->post('/register', [
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'teacher',
            'employee_id' => 'EMP001',
            'department' => 'Mathematics',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'teacher@example.com')->first();
        $this->assertEquals('teacher', $user->role);
        
        $this->assertDatabaseHas('teachers', [
            'user_id' => $user->id,
            'employee_id' => 'EMP001',
            'department' => 'Mathematics',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_parent_can_register_with_profile(): void
    {
        $response = $this->post('/register', [
            'name' => 'Parent User',
            'email' => 'parent@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'parent',
            'relationship' => 'Father',
            'notification_email' => 'parent.notif@example.com',
        ]);

        $this->assertAuthenticated();
        $user = User::where('email', 'parent@example.com')->first();
        $this->assertEquals('parent', $user->role);
        
        $this->assertDatabaseHas('parents', [
            'user_id' => $user->id,
            'relationship' => 'Father',
            'notification_email' => 'parent.notif@example.com',
        ]);

        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
