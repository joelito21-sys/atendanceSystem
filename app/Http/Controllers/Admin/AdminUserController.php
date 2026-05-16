<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index(): View
    {
        $admins = User::where('role', 'admin')->paginate(15);
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create(): View
    {
        return view('admin.admins.create');
    }

    /**
     * Store a newly created admin in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'New administrator account created successfully.');
    }

    /**
     * Show the form for editing an admin.
     */
    public function edit(User $admin): View
    {
        if ($admin->role !== 'admin') {
            abort(403);
        }
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, User $admin): RedirectResponse
    {
        if ($admin->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$admin->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrator account updated successfully.');
    }

    /**
     * Remove the specified admin from storage.
     */
    public function destroy(User $admin): RedirectResponse
    {
        // Don't let an admin delete themselves
        if (auth()->id() === $admin->id) {
            return back()->with('error', 'You cannot delete your own administrator account.');
        }

        if ($admin->role !== 'admin') {
            abort(403);
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Administrator account removed successfully.');
    }
}
