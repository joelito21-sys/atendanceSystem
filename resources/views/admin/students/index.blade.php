<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Students') }}
            </h2>
            <a href="{{ route('admin.students.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                + Add Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Student</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade/Section</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Parent</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($students as $student)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                                <span class="text-indigo-600 font-medium">{{ substr($student->user->name ?? 'N', 0, 1) }}</span>
                                            </div>
                                            <div class="ml-3">
                                                <p class="font-medium text-gray-800">{{ $student->user->name ?? 'N/A' }}</p>
                                                <p class="text-sm text-gray-500">{{ $student->user->email ?? '' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $student->student_id_number }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $student->grade_level }} - {{ $student->section }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $student->parent->user->name ?? 'Not assigned' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('admin.attendance.student-preview', $student) }}" class="text-purple-600 hover:text-purple-800" target="_blank" title="Preview Student Portal">Preview</a>
                                            <a href="{{ route('admin.students.show', $student) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                            <a href="{{ route('admin.students.edit', $student) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                            <a href="{{ route('admin.students.qr-code', $student) }}" class="text-green-600 hover:text-green-800">QR</a>
                                            <form action="{{ route('admin.students.destroy', $student) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        No students found. <a href="{{ route('admin.students.create') }}" class="text-indigo-600 hover:underline">Add your first student</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($students->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $students->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
