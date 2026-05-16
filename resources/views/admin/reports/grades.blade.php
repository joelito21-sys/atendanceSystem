@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-violet-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Grade Report</h1>
                <p class="mt-2 text-gray-600">View and export student grades</p>
            </div>
            <a href="{{ route('admin.reports.index') }}" 
               class="inline-flex items-center text-violet-600 hover:text-violet-800">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Reports
            </a>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <form method="GET" action="{{ route('admin.reports.grades') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Student</label>
                    <select name="student_id" class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500">
                        <option value="">All Students</option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->user->name ?? 'N/A' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                    <select name="subject_id" class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Grade Type</label>
                    <select name="grade_type" class="w-full rounded-lg border-gray-300 focus:border-violet-500 focus:ring-violet-500">
                        <option value="">All Types</option>
                        <option value="quiz" {{ request('grade_type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="exam" {{ request('grade_type') == 'exam' ? 'selected' : '' }}>Exam</option>
                        <option value="project" {{ request('grade_type') == 'project' ? 'selected' : '' }}>Project</option>
                        <option value="assignment" {{ request('grade_type') == 'assignment' ? 'selected' : '' }}>Assignment</option>
                        <option value="final" {{ request('grade_type') == 'final' ? 'selected' : '' }}>Final</option>
                    </select>
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 bg-violet-600 text-white px-4 py-2 rounded-lg hover:bg-violet-700 transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('admin.reports.grades.pdf', request()->all()) }}" 
                       class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors">
                        PDF
                    </a>
                </div>
            </form>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-lg p-6">
                <p class="text-sm text-gray-500 font-medium">Total Grades</p>
                <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <p class="text-sm text-blue-600 font-medium">Average</p>
                <p class="text-3xl font-bold text-blue-700 mt-2">{{ number_format($stats['average'], 2) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <p class="text-sm text-green-600 font-medium">Highest</p>
                <p class="text-3xl font-bold text-green-700 mt-2">{{ number_format($stats['highest'], 2) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-lg p-6">
                <p class="text-sm text-red-600 font-medium">Lowest</p>
                <p class="text-3xl font-bold text-red-700 mt-2">{{ number_format($stats['lowest'], 2) }}</p>
            </div>
        </div>

        <!-- Grades Table -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teacher</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($grades as $grade)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $grade->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $grade->student->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $grade->subject->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($grade->grade_type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold 
                                        @if($grade->grade >= 90) text-green-600
                                        @elseif($grade->grade >= 80) text-blue-600
                                        @elseif($grade->grade >= 75) text-yellow-600
                                        @else text-red-600
                                        @endif">
                                        {{ number_format($grade->grade, 2) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $grade->teacher->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.reports.transcript', $grade->student_id) }}" 
                                       class="text-violet-600 hover:text-violet-900">Transcript</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                    No grades found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($grades->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $grades->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
