<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Parent/Guardian Details') }}</h2>
            <a href="{{ route('admin.parents.edit', $parent) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Edit</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-rose-500 to-pink-600 rounded-2xl shadow-xl p-6 lg:p-8 text-white mb-8">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-3xl font-bold">{{ substr($parent->user->name ?? 'P', 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $parent->user->name ?? 'Unknown' }}</h1>
                        <p class="text-rose-100">{{ $parent->relationship }}</p>
                        <p class="text-rose-200 text-sm mt-1">{{ $parent->notification_email }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Contact Information</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between"><dt class="text-gray-500">Login Email</dt><dd class="text-gray-800">{{ $parent->user->email ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Notification Email</dt><dd class="text-gray-800">{{ $parent->notification_email }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Phone</dt><dd class="text-gray-800">{{ $parent->phone_number ?? 'N/A' }}</dd></div>
                        <div class="flex justify-between"><dt class="text-gray-500">Notifications</dt><dd><span class="px-2 py-1 text-xs rounded-full {{ $parent->receive_notifications ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $parent->receive_notifications ? 'Enabled' : 'Disabled' }}</span></dd></div>
                    </dl>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Children ({{ $parent->students->count() }})</h3>
                    @if($parent->students->count() > 0)
                        <div class="space-y-3">
                            @foreach($parent->students as $student)
                                <a href="{{ route('admin.students.show', $student) }}" class="block bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                    <p class="font-medium text-gray-800">{{ $student->user->name ?? 'Unknown' }}</p>
                                    <p class="text-sm text-gray-500">{{ $student->grade_level }} - {{ $student->section }}</p>
                                    <p class="text-sm text-indigo-600">ID: {{ $student->student_id_number }}</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No children linked yet</p>
                    @endif
                </div>
            </div>

            <div class="mt-6"><a href="{{ route('admin.parents.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Parents</a></div>
        </div>
    </div>
</x-app-layout>
