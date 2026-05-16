<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ParentController;
use App\Http\Controllers\Admin\PreEnrollmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard - redirects based on role
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Student Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/qr-code', [QrCodeController::class, 'show'])->name('qr-code');
    Route::post('/qr-code/generate', [QrCodeController::class, 'generate'])->name('qr-code.generate');
    Route::get('/attendance', [AttendanceController::class, 'studentIndex'])->name('attendance');
    Route::get('/grades', [GradeController::class, 'studentIndex'])->name('grades');
});

// Teacher Routes
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/scanner', [AttendanceController::class, 'scanner'])->name('scanner');
    Route::post('/attendance/time-in', [AttendanceController::class, 'timeIn'])->name('attendance.time-in');
    Route::post('/attendance/time-out', [AttendanceController::class, 'timeOut'])->name('attendance.time-out');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    
    // Grades
    Route::get('/grades', [GradeController::class, 'teacherIndex'])->name('grades.index');
    Route::get('/grades/create', [GradeController::class, 'create'])->name('grades.create');
    Route::post('/grades', [GradeController::class, 'store'])->name('grades.store');
    Route::get('/grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
    Route::put('/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
    Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
    Route::get('/grades/bulk', [GradeController::class, 'bulkCreate'])->name('grades.bulk-create');
    Route::post('/grades/bulk', [GradeController::class, 'bulkStore'])->name('grades.bulk-store');
    Route::get('/grades/template', [GradeController::class, 'downloadTemplate'])->name('grades.template');
    Route::post('/grades/import', [GradeController::class, 'import'])->name('grades.import');

    // Grades
    Route::get('/grades', [GradeController::class, 'teacherIndex'])->name('grades.index');
    // ... rest of grades routes ...
    
    // My Students / Roster
    Route::get('/roster', [App\Http\Controllers\Teacher\RosterController::class, 'index'])->name('roster.index');
    Route::get('/roster/subject/{subject}', [App\Http\Controllers\Teacher\RosterController::class, 'subjectRoster'])->name('roster.subject');

    // Pre-Enrollment Management (Teachers can add students to their own subjects)
    Route::get('pre-enrollments/subjects', [PreEnrollmentController::class, 'getSubjects'])->name('pre-enrollments.get-subjects');
    Route::resource('pre-enrollments', PreEnrollmentController::class);
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Global Search
    Route::get('/search', [App\Http\Controllers\Admin\SearchController::class, 'index'])->name('search');

    // Students
    Route::resource('students', StudentController::class);
    Route::get('/students/{student}/qr-code', [QrCodeController::class, 'adminShow'])->name('students.qr-code');
    Route::post('/qr-codes/generate-all', [QrCodeController::class, 'generateAll'])->name('qr-codes.generate-all');
    
    // Teachers
    Route::resource('teachers', TeacherController::class);
    
    // Subjects
    Route::resource('subjects', SubjectController::class);
    
    // Parents
    Route::resource('parents', ParentController::class);
    
    // Class Schedules
    Route::resource('schedules', App\Http\Controllers\Admin\ClassScheduleController::class);
    
    // Course Management
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);

    // Admin Account Management
    Route::resource('admins', App\Http\Controllers\Admin\AdminUserController::class);

    // Email History/Logs
    Route::get('/email-logs', [App\Http\Controllers\Admin\EmailLogController::class, 'index'])->name('email-logs.index');
    Route::post('/email-logs/clear', [App\Http\Controllers\Admin\EmailLogController::class, 'clearAll'])->name('email-logs.clear');

    // System Settings
    Route::get('/settings', [App\Http\Controllers\Admin\SystemSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SystemSettingController::class, 'update'])->name('settings.update');
    
    // Master Enrollment List
    Route::get('pre-enrollments/subjects', [PreEnrollmentController::class, 'getSubjects'])->name('pre-enrollments.get-subjects');
    Route::post('pre-enrollments/sync-all', [PreEnrollmentController::class, 'syncAll'])->name('pre-enrollments.sync-all');
    Route::resource('pre-enrollments', PreEnrollmentController::class);
    
    // Reports & Analytics
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/attendance', [App\Http\Controllers\ReportController::class, 'attendanceReport'])->name('reports.attendance');
    Route::get('/reports/attendance/pdf', [App\Http\Controllers\ReportController::class, 'exportAttendancePDF'])->name('reports.attendance.pdf');
    Route::get('/reports/grades', [App\Http\Controllers\ReportController::class, 'gradeReport'])->name('reports.grades');
    Route::get('/reports/grades/pdf', [App\Http\Controllers\ReportController::class, 'exportGradePDF'])->name('reports.grades.pdf');
    Route::get('/reports/transcript/{student}', [App\Http\Controllers\ReportController::class, 'studentTranscript'])->name('reports.transcript');
    Route::get('/analytics', [App\Http\Controllers\ReportController::class, 'analytics'])->name('analytics');
    
    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance');
    
    // Scanner (admin can also use)
    Route::get('/scanner', [AttendanceController::class, 'scanner'])->name('scanner');
    Route::post('/attendance/time-in', [AttendanceController::class, 'timeIn'])->name('attendance.time-in');
    Route::post('/attendance/time-out', [AttendanceController::class, 'timeOut'])->name('attendance.time-out');
    
    // Preview Student View (Admin Only)
    Route::get('/attendance/student/{student}', [AttendanceController::class, 'studentIndex'])->name('attendance.student-preview');

    // Holidays
    Route::resource('holidays', App\Http\Controllers\Admin\HolidayController::class);
});

// Parent Routes
Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\ParentDashboardController::class, 'index'])->name('dashboard');
    Route::get('/child/{student}', [App\Http\Controllers\ParentDashboardController::class, 'showChild'])->name('child.show');
    Route::get('/child/{student}/attendance', [App\Http\Controllers\ParentDashboardController::class, 'childAttendance'])->name('child.attendance');
    Route::get('/child/{student}/grades', [App\Http\Controllers\ParentDashboardController::class, 'childGrades'])->name('child.grades');
});

// API routes for QR verification (can be accessed by teachers/admin)
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::post('/qr-code/verify', [QrCodeController::class, 'verify'])->name('qr-code.verify');
    Route::post('/attendance/process', [AttendanceController::class, 'process'])->name('attendance.process');
});

// Notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
});

// Announcements
Route::middleware(['auth'])->group(function () {
    Route::get('/announcements', [App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'show'])->name('announcements.show');
    
    // Only Admin can manage announcements
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/announcements/create', [App\Http\Controllers\AnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [App\Http\Controllers\AnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [App\Http\Controllers\AnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [App\Http\Controllers\AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });
});

require __DIR__.'/auth.php';
