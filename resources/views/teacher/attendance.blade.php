<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Attendance <span class="text-gradient">Records</span>
            </h2>
            <p class="text-slate-500 mt-1">View and monitor student attendance across your subjects.</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Filters -->
        <div class="glass-card p-8">
            <form method="GET" action="{{ route('teacher.attendance') }}" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div>
                    <label for="subject_id" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Subject</label>
                    <select name="subject_id" id="subject_id" class="premium-input w-full">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }} ({{ $subject->code }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="date" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Date</label>
                    <input type="date" name="date" id="date" value="{{ request('date', today()->format('Y-m-d')) }}" class="premium-input w-full">
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="premium-button-primary flex-1 h-[42px]">
                        Filter Logs
                    </button>
                    <a href="{{ route('teacher.attendance') }}" class="premium-button bg-slate-100 text-slate-600 hover:bg-slate-200 h-[42px] flex items-center">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Attendance Table -->
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Student</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Subject</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Time In</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Time Out</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($attendance as $record)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs">
                                            {{ substr($record->student->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $record->student->user->name }}</p>
                                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tight">{{ $record->student->student_id_number }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <p class="text-xs font-bold text-slate-600">{{ $record->subject->name }}</p>
                                    <p class="text-[10px] font-black text-slate-400 uppercase">{{ $record->subject->code }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-black text-slate-700">
                                        {{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('h:i A') : '--:--' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-black text-slate-700">
                                        {{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('h:i A') : '--:--' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($record->status === 'present')
                                        <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-600 text-[10px] font-black uppercase tracking-widest">
                                            Present
                                        </span>
                                    @elseif($record->status === 'late')
                                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-600 text-[10px] font-black uppercase tracking-widest">
                                            Late
                                        </span>
                                    @elseif($record->status === 'absent')
                                        <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-600 text-[10px] font-black uppercase tracking-widest">
                                            Absent
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest">
                                            {{ ucfirst($record->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-slate-300 mb-2">
                                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No attendance records found for this selection</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($attendance->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                    {{ $attendance->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
