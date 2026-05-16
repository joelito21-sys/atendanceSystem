<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $holidays = \App\Models\Holiday::orderBy('date', 'desc')->get();
        return view('admin.holidays.index', compact('holidays'));
    }

    public function create() { }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        $holiday = \App\Models\Holiday::create($validated);

        // Notify students and parents
        $users = \App\Models\User::whereIn('role', ['student', 'parent'])->pluck('id');

        $notifications = [];
        $now = now();
        foreach ($users as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'title' => 'Upcoming Holiday: ' . $holiday->name,
                'message' => 'Please be informed that ' . \Carbon\Carbon::parse($holiday->date)->format('F d, Y') . ' has been declared a holiday.',
                'type' => 'info',
                'link' => null,
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($notifications, 500) as $chunk) {
            \App\Models\CustomNotification::insert($chunk);
        }

        return redirect()->route('admin.holidays.index')->with('success', 'Holiday created and notifications sent to students and parents.');
    }

    public function show(string $id) { }
    public function edit(string $id) { }
    public function update(Request $request, string $id) { }

    public function destroy(string $id)
    {
        $holiday = \App\Models\Holiday::findOrFail($id);
        $holiday->delete();
        
        return redirect()->route('admin.holidays.index')->with('success', 'Holiday deleted successfully.');
    }
}
