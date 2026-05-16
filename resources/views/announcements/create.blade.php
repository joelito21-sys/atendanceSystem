@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 max-w-2xl">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Create Announcement</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('announcements.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required value="{{ old('title') }}">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-bold mb-2">Content</label>
                <textarea name="content" id="content" rows="6" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>{{ old('content') }}</textarea>
                @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="priority" class="block text-gray-700 font-bold mb-2">Priority</label>
                    <select name="priority" id="priority" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div>
                    <label for="target_role" class="block text-gray-700 font-bold mb-2">Target Audience</label>
                    <select name="target_role" id="target_role" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                        <option value="">All Users</option>
                        <option value="student">Students</option>
                        <option value="parent">Parents</option>
                        <option value="teacher">Teachers</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label for="expires_at" class="block text-gray-700 font-bold mb-2">Expires At (Optional)</label>
                <input type="date" name="expires_at" id="expires_at" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" value="{{ old('expires_at') }}">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('announcements.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Announcement</button>
            </div>
        </form>
    </div>
</div>
@endsection
