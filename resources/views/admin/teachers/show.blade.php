<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Teacher Details') }}</h2>
            <a href="{{ route('admin.teachers.edit', $teacher) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Edit</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-emerald-600 to-teal-600 rounded-2xl shadow-xl p-6 lg:p-8 text-black mb-8">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-3xl font-bold">{{ substr($teacher->user->name ?? 'T', 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $teacher->user->name ?? 'Unknown' }}</h1>
                        <p class="text-emerald-100">{{ $teacher->department ?? 'No Department' }}</p>
                        <p class="text-emerald-200 text-sm mt-1">Employee ID: {{ $teacher->employee_id }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Contact Information</h3>
    <dl class="space-y-3">
        <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd class="text-gray-800">{{ $teacher->user->email ?? 'N/A' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Phone</dt><dd class="text-gray-800">{{ $teacher->phone ?? 'N/A' }}</dd></div>
        <div class="flex justify-between"><dt class="text-gray-500">Address</dt><dd class="text-gray-800">{{ $teacher->address ?? 'N/A' }}</dd></div>
    </dl>
</div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Assigned Subjects ({{ $teacher->subjects->count() }})</h3>
                    @if($teacher->subjects->count() > 0)
                        <div class="space-y-2">
                            @foreach($teacher->subjects as $subject)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="font-medium text-gray-800">{{ $subject->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $subject->code }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No subjects assigned</p>
                    @endif
                </div>
            </div>

            <div class="mt-6"><a href="{{ route('admin.teachers.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Teachers</a></div>
        </div>
    </div>
</x-app-layout>
