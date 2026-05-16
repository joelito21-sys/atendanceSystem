<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display user notifications
     */
    public function index(): View
    {
        $user = auth()->user();
        $notifications = \App\Models\CustomNotification::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = \App\Models\CustomNotification::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $notification->update(['read_at' => now()]);
        
        return back();
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        \App\Models\CustomNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
            
        return back();
    }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        $notification = \App\Models\CustomNotification::where('user_id', auth()->id())
            ->findOrFail($id);
            
        $notification->delete();
        
        return back()->with('success', 'Notification removed.');
    }
}
