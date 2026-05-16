@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-violet-50 via-white to-purple-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Edit Class Schedule</h1>
            <p class="mt-2 text-gray-600">Update schedule information</p>
        </div>

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.schedules.index') }}" class="inline-flex items-center text-violet-600 hover:text-violet-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Schedules
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-xl shadow-lg p-8">
            @if($errors->has('conflict'))
                <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <p class="text-red-800">{{ $errors->first('conflict') }}</p>
                </div>
            @endif

            <form action="{{ route('admin.schedules.update', $schedule) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Subject Selection -->
                <div class="mb-6">
                    <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Subject <span class="text-red-500">*</span>
                    </label>
                    <select id="subject_id" name="subject_id" required
                            class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500 @error('subject_id') border-red-500 @enderror">
                        <option value="">Select Subject</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ old('subject_id', $schedule->subject_id) == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }} ({{ $subject->code }}) - {{ $subject->teacher->user->name ?? 'No Teacher' }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Section -->
                <div class="mb-6">
                    <label for="section" class="block text-sm font-medium text-gray-700 mb-2">
                        Section <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="section" name="section" required
                           value="{{ old('section', $schedule->section) }}"
                           class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500 @error('section') border-red-500 @enderror"
                           placeholder="e.g., BSIT-1A, Grade 7-Emerald">
                    @error('section')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Day of Week -->
                <div class="mb-6">
                    <label for="day_of_week" class="block text-sm font-medium text-gray-700 mb-2">
                        Day of Week <span class="text-red-500">*</span>
                    </label>
                    <select id="day_of_week" name="day_of_week" required
                            class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500 @error('day_of_week') border-red-500 @enderror">
                        <option value="">Select Day</option>
                        <option value="Monday" {{ old('day_of_week', $schedule->day_of_week) == 'Monday' ? 'selected' : '' }}>Monday</option>
                        <option value="Tuesday" {{ old('day_of_week', $schedule->day_of_week) == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                        <option value="Wednesday" {{ old('day_of_week', $schedule->day_of_week) == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                        <option value="Thursday" {{ old('day_of_week', $schedule->day_of_week) == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                        <option value="Friday" {{ old('day_of_week', $schedule->day_of_week) == 'Friday' ? 'selected' : '' }}>Friday</option>
                        <option value="Saturday" {{ old('day_of_week', $schedule->day_of_week) == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                        <option value="Sunday" {{ old('day_of_week', $schedule->day_of_week) == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                    </select>
                    @error('day_of_week')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Time Range -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">
                            Start Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="start_time" name="start_time" required
                               value="{{ old('start_time', substr($schedule->start_time, 0, 5)) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500 @error('start_time') border-red-500 @enderror">
                        @error('start_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">
                            End Time <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="end_time" name="end_time" required
                               value="{{ old('end_time', substr($schedule->end_time, 0, 5)) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500 @error('end_time') border-red-500 @enderror">
                        @error('end_time')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Room -->
                <div class="mb-6">
                    <label for="room" class="block text-sm font-medium text-gray-700 mb-2">
                        Room <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="room" name="room" required
                           value="{{ old('room', $schedule->room) }}"
                           class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500 @error('room') border-red-500 @enderror"
                           placeholder="e.g., Room 101, Lab A">
                    @error('room')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.schedules.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700 transition-colors">
                        Update Schedule
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
