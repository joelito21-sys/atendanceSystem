<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Subject Details') }}</h2>
            <a href="{{ route('admin.subjects.edit', $subject) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Edit</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl shadow-xl p-6 lg:p-8 text-white mb-8">
                <h1 class="text-2xl font-bold">{{ $subject->name }}</h1>
                <p class="text-amber-100">{{ $subject->code }} • {{ $subject->units }} units</p>
                <p class="text-amber-200 text-sm mt-2">{{ $subject->grade_level ?? 'All Grades' }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Subject Information</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between"><dt class="text-gray-500">Teacher</dt><dd class="text-gray-800">{{ $subject->teacher->user->name ?? 'Not Assigned' }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Status</dt><dd><span class="px-2 py-1 text-xs rounded-full {{ $subject->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $subject->is_active ? 'Active' : 'Inactive' }}</span></dd></div>
                        <div><dt class="text-gray-500">Description</dt><dd class="text-gray-800 mt-1">{{ $subject->description ?? 'No description' }}</dd></div>
                    </dl>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Class Schedules</h3>
                    @if($subject->classSchedules->count() > 0)
                        <div class="space-y-2">
                            @foreach($subject->classSchedules as $schedule)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="font-medium text-gray-800">{{ $schedule->day_of_week }}</p>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}</p>
                                    <p class="text-sm text-indigo-600">{{ $schedule->room }} ({{ $schedule->section }})</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No schedules set</p>
                    @endif
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Enrolled Students ({{ $subject->students->count() }})</h3>
                    @if($subject->students->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach($subject->students as $student)
                                <div class="bg-gray-50 rounded-lg p-3 text-center">
                                    <p class="font-medium text-gray-800 text-sm">{{ $student->user->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-gray-500">{{ $student->student_id_number }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No students enrolled</p>
                    @endif
                </div>
            </div>

            <div class="mt-6"><a href="{{ route('admin.subjects.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Subjects</a></div>
        </div>
    </div>
</x-app-layout>
