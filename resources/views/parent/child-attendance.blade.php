<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Attendance <span class="text-gradient">Records</span>
            </h2>
            <p class="text-slate-500 mt-1">Monitoring {{ $student->user->name }}'s class presence</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Back Button & Student Info -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <a href="{{ route('parent.dashboard') }}" class="premium-button bg-white text-slate-600 hover:text-sky-600 flex items-center w-fit border border-slate-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Dashboard
            </a>
            <div class="text-right">
                <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Student ID</p>
                <p class="text-sm font-bold text-slate-800">{{ $student->student_id }}</p>
            </div>
        </div>

        <!-- Attendance Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="glass-card p-6 flex items-center gap-6 border-l-4 border-l-slate-400">
                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-600 flex items-center justify-center">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="text-2xl font-black text-slate-800">{{ $attendanceStats['total_days'] }}</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Logs</p>
                </div>
            </div>

            <div class="glass-card p-6 flex items-center gap-6 border-l-4 border-l-emerald-500">
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center font-black">
                    {{ $attendanceStats['present_days'] }}
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-800">Present</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Successful Logs</p>
                </div>
            </div>

            <div class="glass-card p-6 flex items-center gap-6 border-l-4 border-l-rose-500">
                <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-black">
                    {{ $attendanceStats['absent_days'] }}
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-800">Absent</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Missed Classes</p>
                </div>
            </div>

            <div class="glass-card p-6 flex items-center gap-6 border-l-4 border-l-amber-500">
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-black">
                    {{ $attendanceStats['late_days'] }}
                </div>
                <div>
                    <h3 class="text-lg font-black text-slate-800">Late</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Delayed Entry</p>
                </div>
            </div>
        </div>

        <!-- Attendance Records Table -->
        <div class="overflow-hidden bg-white rounded-3xl border border-slate-100 shadow-sm">
            <div class="p-6 border-b border-slate-50 flex items-center justify-between">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Detailed Logs</h3>
                <span class="text-[10px] font-bold text-slate-400 uppercase">Chronological Order</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Subject</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Session</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($attendanceRecords as $record)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-bold text-slate-700">
                                    {{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-slate-800">{{ $record->subject->name ?? 'N/A' }}</div>
                                    <div class="text-[10px] font-bold text-slate-400 tracking-widest">{{ $record->subject->code ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="flex flex-col">
                                            <span class="text-xs font-bold text-slate-600">IN: {{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('h:i A') : '--:--' }}</span>
                                            <span class="text-xs font-bold text-slate-400">OUT: {{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('h:i A') : '--:--' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($record->status === 'present')
                                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            Present
                                        </span>
                                    @elseif($record->status === 'absent')
                                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg bg-rose-50 text-rose-600 border border-rose-100">
                                            Absent
                                        </span>
                                    @elseif($record->status === 'late')
                                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg bg-amber-50 text-amber-600 border border-amber-100">
                                            Late
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg bg-slate-100 text-slate-600 border border-slate-200">
                                            {{ $record->status }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No Log Data Found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($attendanceRecords->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                    {{ $attendanceRecords->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
