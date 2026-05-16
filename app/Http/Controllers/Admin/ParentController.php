<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ParentModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $parents = ParentModel::with(['user', 'students.user'])->paginate(20);
        return view('admin.parents.index', compact('parents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.parents.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'notification_email' => ['required', 'email', 'max:255'],
            'relationship' => ['required', 'string', 'max:50'],
            'receive_notifications' => ['boolean'],
        ]);

        // Create user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'parent',
        ]);

        // Create parent profile
        ParentModel::create([
            'user_id' => $user->id,
            'phone_number' => $validated['phone_number'],
            'notification_email' => $validated['notification_email'],
            'relationship' => $validated['relationship'],
            'receive_notifications' => $request->has('receive_notifications'),
        ]);

        return redirect()->route('admin.parents.index')
            ->with('success', 'Parent/Guardian created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ParentModel $parent): View
    {
        $parent->load(['user', 'students.user']);
        return view('admin.parents.show', compact('parent'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ParentModel $parent): View
    {
        return view('admin.parents.edit', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ParentModel $parent): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $parent->user_id],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'notification_email' => ['required', 'email', 'max:255'],
            'relationship' => ['required', 'string', 'max:50'],
            'receive_notifications' => ['boolean'],
        ]);

        // Update user
        $parent->user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update parent
        $parent->update([
            'phone_number' => $validated['phone_number'],
            'notification_email' => $validated['notification_email'],
            'relationship' => $validated['relationship'],
            'receive_notifications' => $request->has('receive_notifications'),
        ]);

        return redirect()->route('admin.parents.index')
            ->with('success', 'Parent/Guardian updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ParentModel $parent): RedirectResponse
    {
        $parent->user->delete();
        
        return redirect()->route('admin.parents.index')
            ->with('success', 'Parent/Guardian deleted successfully!');
    }
}
