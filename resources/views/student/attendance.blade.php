<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <form method="GET" class="flex flex-wrap gap-4">
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select name="subject_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Subjects</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Attendance Stats by Subject -->
            @if(count($stats) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($subjects as $subject)
                        @if(isset($stats[$subject->id]))
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="font-semibold text-gray-800 mb-4">{{ $subject->name }}</h3>
                                <div class="grid grid-cols-3 gap-4 text-center mb-4">
                                    <div>
                                        <p class="text-2xl font-bold text-green-600">{{ $stats[$subject->id]['present'] }}</p>
                                        <p class="text-xs text-gray-500">Present</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-yellow-600">{{ $stats[$subject->id]['late'] }}</p>
                                        <p class="text-xs text-gray-500">Late</p>
                                    </div>
                                    <div>
                                        <p class="text-2xl font-bold text-red-600">{{ $stats[$subject->id]['absent'] }}</p>
                                        <p class="text-xs text-gray-500">Absent</p>
                                    </div>
                                </div>
                                <div class="bg-gray-200 rounded-full h-2">
                                    <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $stats[$subject->id]['percentage'] }}%"></div>
                                </div>
                                <p class="text-sm text-center text-gray-600 mt-2">{{ $stats[$subject->id]['percentage'] }}% Attendance Rate</p>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif

            <!-- Attendance Records -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Attendance History</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time In</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time Out</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($attendance as $record)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $record->date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $record->subject->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('h:i A') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('h:i A') : '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full
                                            @if($record->status === 'present') bg-green-100 text-green-800
                                            @elseif($record->status === 'late') bg-yellow-100 text-yellow-800
                                            @elseif($record->status === 'excused') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                        No attendance records yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($attendance->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $attendance->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
