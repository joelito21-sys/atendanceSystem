<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                System <span class="text-gradient">Analytics</span>
            </h2>
            <p class="text-slate-500 mt-1">Real-time insights and academic performance trends</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-card p-6 flex items-center gap-6 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-sky-500/5 rounded-full"></div>
                <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center font-black">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Students</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $totalStudents }}</h3>
                </div>
            </div>

            <div class="glass-card p-6 flex items-center gap-6 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-indigo-500/5 rounded-full"></div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center font-black">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Teachers</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $totalTeachers }}</h3>
                </div>
            </div>

            <div class="glass-card p-6 flex items-center gap-6 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-rose-500/5 rounded-full"></div>
                <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-black">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                </div>
                <div>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest">Total Subjects</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $totalSubjects }}</h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Attendance Summary -->
            <div class="glass-card">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Attendance Breakdown</h3>
                    <span class="text-xs font-bold text-slate-400">Last 30 Days</span>
                </div>
                <div class="p-8 space-y-6">
                    @php
                        $totalAttendance = array_sum($attendanceStats ?: [1]);
                    @endphp
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-slate-700">Present</span>
                            <span class="text-xl font-black text-emerald-600">{{ $attendanceStats['present'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3">
                            <div class="bg-emerald-500 h-3 rounded-full shadow-[0_0_10px_rgba(16,185,129,0.3)] transition-all duration-1000" style="width: {{ ($attendanceStats['present'] ?? 0) / $totalAttendance * 100 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-slate-700">Late</span>
                            <span class="text-xl font-black text-amber-600">{{ $attendanceStats['late'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3">
                            <div class="bg-amber-500 h-3 rounded-full shadow-[0_0_10px_rgba(245,158,11,0.3)] transition-all duration-1000" style="width: {{ ($attendanceStats['late'] ?? 0) / $totalAttendance * 100 }}%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm font-bold text-slate-700">Absent</span>
                            <span class="text-xl font-black text-rose-600">{{ $attendanceStats['absent'] ?? 0 }}</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3">
                            <div class="bg-rose-500 h-3 rounded-full shadow-[0_0_10px_rgba(244,63,94,0.3)] transition-all duration-1000" style="width: {{ ($attendanceStats['absent'] ?? 0) / $totalAttendance * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absentee Trends -->
            <div class="glass-card">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight text-rose-600">Absentee Trends</h3>
                    <span class="text-xs font-bold text-slate-400">Daily Absences (Last 14 Days)</span>
                </div>
                <div class="p-4 overflow-hidden">
                    <div class="h-64 flex items-end gap-2 px-4">
                        @forelse($absenteeTrends as $trend)
                            @php
                                $maxAbsences = $absenteeTrends->max('count');
                                $height = $maxAbsences > 0 ? ($trend->count / $maxAbsences * 100) : 0;
                            @endphp
                            <div class="flex-1 group relative flex flex-col items-center">
                                <div class="w-full bg-rose-400/20 rounded-t-lg transition-all duration-700 hover:bg-rose-500/40 relative overflow-hidden" 
                                     style="height: {{ $height }}%">
                                     <div class="absolute bottom-0 left-0 w-full h-0 group-hover:h-full bg-rose-500 transition-all duration-300"></div>
                                </div>
                                <div class="absolute -top-8 bg-slate-800 text-white text-[10px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                    {{ $trend->count }} absents
                                </div>
                                <span class="text-[9px] font-black text-slate-400 mt-2 uppercase">{{ \Carbon\Carbon::parse($trend->date)->format('D d') }}</span>
                            </div>
                        @empty
                            <div class="w-full h-full flex items-center justify-center text-slate-300 italic">No absence data recorded</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            <!-- Subject Performance -->
            <div class="glass-card">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Best Attendance by Subject</h3>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 uppercase tracking-widest text-[10px] font-black text-slate-400">
                                <tr>
                                    <th class="px-6 py-4">Subject</th>
                                    <th class="px-6 py-4">Instructor</th>
                                    <th class="px-6 py-4 text-right">Attendance Rate</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($subjectAttendance as $subject)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 font-bold text-slate-700">
                                            <div class="flex items-center gap-3">
                                                <div class="w-2 h-8 bg-sky-500 rounded-full"></div>
                                                <div>
                                                    <div class="text-sm">{{ $subject->name }}</div>
                                                    <div class="text-[10px] text-slate-400">{{ $subject->code }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-slate-500 font-medium text-sm">
                                            {{ $subject->teacher->user->name ?? 'Unassigned' }}
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-lg font-black text-sky-600">{{ $subject->attendance_percentage }}%</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="px-6 py-10 text-center text-slate-400">Insufficient data</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Grade Performance -->
            <div class="glass-card">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Top Students Rank</h3>
                    <a href="{{ route('admin.reports.index') }}" class="text-xs font-bold text-sky-500 hover:underline">Full Reports &rarr;</a>
                </div>
                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 uppercase tracking-widest text-[10px] font-black text-slate-400">
                                <tr>
                                    <th class="px-6 py-4">Rank</th>
                                    <th class="px-6 py-4">Student Name</th>
                                    <th class="px-6 py-4 text-right">GPA</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($topStudents as $index => $student)
                                    <tr class="hover:bg-slate-50/50 transition-colors group">
                                        <td class="px-6 py-4">
                                            <div class="w-8 h-8 rounded-full {{ $index === 0 ? 'bg-amber-100 text-amber-600' : ($index === 1 ? 'bg-slate-200 text-slate-600' : ($index === 2 ? 'bg-orange-100 text-orange-600' : 'bg-slate-50 text-slate-400')) }} flex items-center justify-center font-black text-xs">
                                                #{{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-slate-700">{{ $student->user->name ?? 'N/A' }}</div>
                                            <div class="text-[10px] text-slate-400">{{ $student->student_id_number }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <span class="text-lg font-black text-emerald-600">{{ number_format($student->grades_avg_grade, 2) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
