<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailLogController extends Controller
{
    /**
     * Display a listing of the email logs.
     */
    public function index(): View
    {
        $logs = EmailLog::with(['student.user', 'parent.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.email-logs.index', compact('logs'));
    }

    /**
     * Display the specified email log.
     */
    public function show(EmailLog $log): View
    {
        $log->load(['student.user', 'parent.user']);
        return view('admin.email-logs.show', compact('log'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailLog $log)
    {
        $log->delete();
        return back()->with('success', 'Email log entry deleted.');
    }

    /**
     * Clear all logs
     */
    public function clearAll()
    {
        EmailLog::truncate();
        return back()->with('success', 'All email logs have been cleared.');
    }
}
