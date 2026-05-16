<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-sky-500 uppercase tracking-widest mb-1">Overview</p>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                    Admin <span class="text-gradient">Dashboard</span>
                </h1>
                <p class="text-slate-500 mt-1 text-sm">System overview and management center.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.students.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-sky-600 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-sky-100 hover:bg-sky-700 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Student
                </a>
                <a href="{{ route('admin.teachers.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-slate-700 text-sm font-semibold rounded-2xl border border-slate-200 shadow-sm hover:bg-slate-50 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Teacher
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8">

        {{-- ── STATS CARDS ── --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

            {{-- Total Students --}}
            <div class="glass-card p-6 flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Students</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $stats['total_students'] ?? 0 }}</p>
                    <p class="text-xs text-indigo-500 font-semibold mt-0.5">Enrolled this term</p>
                </div>
                <div class="absolute right-5 top-5 w-16 h-16 rounded-2xl bg-indigo-500/5 flex items-center justify-center">
                    <div class="w-2.5 h-2.5 rounded-full bg-indigo-400"></div>
                </div>
            </div>

            {{-- Total Teachers --}}
            <div class="glass-card p-6 flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Teachers</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $stats['total_teachers'] ?? 0 }}</p>
                    <p class="text-xs text-emerald-500 font-semibold mt-0.5">Active faculty</p>
                </div>
                <div class="absolute right-5 top-5 w-16 h-16 rounded-2xl bg-emerald-500/5 flex items-center justify-center">
                    <div class="w-2.5 h-2.5 rounded-full bg-emerald-400"></div>
                </div>
            </div>

            {{-- Total Subjects --}}
            <div class="glass-card p-6 flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Subjects</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $stats['total_subjects'] ?? 0 }}</p>
                    <p class="text-xs text-amber-500 font-semibold mt-0.5">Across all courses</p>
                </div>
                <div class="absolute right-5 top-5 w-16 h-16 rounded-2xl bg-amber-500/5 flex items-center justify-center">
                    <div class="w-2.5 h-2.5 rounded-full bg-amber-400"></div>
                </div>
            </div>

            {{-- Today's Presence --}}
            <div class="glass-card p-6 flex items-center gap-5 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-rose-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                <div class="w-14 h-14 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Today's Scans</p>
                    <p class="text-3xl font-black text-slate-800 mt-1">{{ $stats['today_attendance'] ?? 0 }}</p>
                    <p class="text-xs text-rose-500 font-semibold mt-0.5">{{ now()->format('M d, Y') }}</p>
                </div>
                <div class="absolute right-5 top-5 w-16 h-16 rounded-2xl bg-rose-500/5 flex items-center justify-center">
                    <div class="w-2.5 h-2.5 rounded-full bg-rose-400"></div>
                </div>
            </div>
        </div>

        {{-- ── MAIN CONTENT GRID ── --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Left 2/3: Recent Attendance Table --}}
            <div class="xl:col-span-2">
                <div class="glass-card overflow-hidden h-full">
                    {{-- Card Header --}}
                    <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-slate-800">Recent Attendance Scans</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Live attendance records from QR scans</p>
                        </div>
                        <a href="{{ route('admin.attendance') }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-600 hover:text-sky-700 px-3 py-1.5 rounded-xl hover:bg-sky-50 transition-all">
                            View All
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>

                    {{-- Table --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="bg-slate-50/70">
                                    <th class="px-7 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Student</th>
                                    <th class="px-7 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Subject</th>
                                    <th class="px-7 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Time</th>
                                    <th class="px-7 py-3.5 text-left text-[11px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100/70">
                                @forelse($recentAttendance ?? [] as $record)
                                    <tr class="hover:bg-sky-50/30 transition-colors group">
                                        <td class="px-7 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-100 to-sky-100 text-indigo-600 flex items-center justify-center font-bold text-sm shrink-0">
                                                    {{ substr($record->student->user->name ?? '?', 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-slate-800">{{ $record->student->user->name ?? 'N/A' }}</p>
                                                    <p class="text-[11px] text-slate-400">ID: {{ $record->student->student_id_number ?? '—' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-7 py-4">
                                            <p class="text-sm font-semibold text-slate-700">{{ $record->subject->name ?? 'N/A' }}</p>
                                            <p class="text-[11px] text-slate-400">{{ $record->subject->code ?? '' }}</p>
                                        </td>
                                        <td class="px-7 py-4">
                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('h:i A') : '—' }}
                                            </p>
                                            @if($record->time_out)
                                                <p class="text-[11px] text-slate-400">Out: {{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }}</p>
                                            @endif
                                        </td>
                                        <td class="px-7 py-4">
                                            @php
                                                $statusColors = [
                                                    'present' => 'bg-emerald-100 text-emerald-700',
                                                    'late'    => 'bg-amber-100 text-amber-700',
                                                    'absent'  => 'bg-rose-100 text-rose-700',
                                                ];
                                                $color = $statusColors[$record->status] ?? 'bg-slate-100 text-slate-600';
                                            @endphp
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $color }}">
                                                {{ $record->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-7 py-16 text-center">
                                            <div class="flex flex-col items-center gap-3 text-slate-400">
                                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                                <p class="text-sm font-medium">No activity recorded today</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right 1/3: Quick Links Panel --}}
            <div class="space-y-5">

                {{-- Management Links --}}
                <div class="glass-card p-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Quick Navigation</h3>
                    <div class="space-y-2">
                        @php
                            $links = [
                                ['href' => route('admin.students.index'),       'label' => 'Student Records',   'sub' => 'All enrolled students',      'color' => 'indigo'],
                                ['href' => route('admin.teachers.index'),       'label' => 'Teacher Records',   'sub' => 'Faculty management',         'color' => 'emerald'],
                                ['href' => route('admin.subjects.index'),       'label' => 'Subjects',          'sub' => 'Subject catalog',            'color' => 'amber'],
                                ['href' => route('admin.parents.index'),        'label' => 'Parents',           'sub' => 'Guardian directory',         'color' => 'sky'],
                                ['href' => route('admin.pre-enrollments.index'),'label' => 'Master Enrollment', 'sub' => 'Enrollment management',      'color' => 'violet'],
                            ];
                            $colorMap = [
                                'indigo'  => 'bg-indigo-50 text-indigo-600 group-hover:bg-indigo-100',
                                'emerald' => 'bg-emerald-50 text-emerald-600 group-hover:bg-emerald-100',
                                'amber'   => 'bg-amber-50 text-amber-600 group-hover:bg-amber-100',
                                'sky'     => 'bg-sky-50 text-sky-600 group-hover:bg-sky-100',
                                'violet'  => 'bg-violet-50 text-violet-600 group-hover:bg-violet-100',
                            ];
                        @endphp
                        @foreach($links as $link)
                            <a href="{{ $link['href'] }}"
                               class="flex items-center gap-4 p-3.5 rounded-2xl hover:bg-slate-50 transition-all group">
                                <div class="w-10 h-10 rounded-xl {{ $colorMap[$link['color']] }} flex items-center justify-center transition-colors shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-800">{{ $link['label'] }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $link['sub'] }}</p>
                                </div>
                                <svg class="w-4 h-4 text-slate-300 group-hover:text-slate-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- System Date/Time Widget --}}
                <div class="glass-card p-6 bg-gradient-to-br from-sky-600 to-indigo-700 text-white">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-sky-200 mb-3">System Status</p>
                    <p class="text-2xl font-black tracking-tight">{{ now()->format('h:i A') }}</p>
                    <p class="text-sky-200 text-sm font-medium mt-1">{{ now()->format('l, F j, Y') }}</p>
                    <div class="mt-5 pt-5 border-t border-white/20 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xl font-black">{{ $stats['today_attendance'] ?? 0 }}</p>
                            <p class="text-[11px] text-sky-200 uppercase tracking-wider font-semibold">Today's Scans</p>
                        </div>
                        <div>
                            <p class="text-xl font-black">{{ $stats['total_students'] ?? 0 }}</p>
                            <p class="text-[11px] text-sky-200 uppercase tracking-wider font-semibold">Students</p>
                        </div>
                    </div>
                </div>

                {{-- Upcoming Holidays --}}
                <div class="glass-card p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Upcoming Holidays</h3>
                        <a href="{{ route('admin.holidays.index') }}" class="text-xs text-sky-600 hover:text-sky-700 font-semibold">View All</a>
                    </div>
                    <div class="space-y-3">
                        @forelse($upcomingHolidays ?? [] as $holiday)
                            <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[13px] font-bold text-slate-800">{{ $holiday->name }}</p>
                                    <p class="text-[11px] text-slate-500 font-medium mt-0.5">{{ \Carbon\Carbon::parse($holiday->date)->format('F d, Y') }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-xs text-slate-400">No upcoming holidays scheduled.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
