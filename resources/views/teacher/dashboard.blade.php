<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-emerald-500 uppercase tracking-widest mb-1">Teacher Portal</p>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                    Welcome back, <span class="text-gradient">{{ auth()->user()->name }}</span> 👋
                </h1>
                <p class="text-slate-500 mt-1 text-sm">Here's what's happening in your classes today — {{ now()->format('l, F j') }}.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('teacher.scanner') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-emerald-100 hover:bg-emerald-700 hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    Open Scanner
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-7">

        {{-- ── TOP STAT CARDS ── --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

            {{-- Scan QR action card --}}
            <a href="{{ route('teacher.scanner') }}"
               class="glass-card p-6 flex flex-col gap-4 group cursor-pointer relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-bold text-slate-800">Scan QR</p>
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">Mark attendance</p>
                </div>
                <div class="flex items-center gap-1 text-emerald-600 text-xs font-semibold">
                    Open scanner
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            {{-- Post Grades action card --}}
            <a href="{{ route('teacher.grades.index') }}"
               class="glass-card p-6 flex flex-col gap-4 group cursor-pointer relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-base font-bold text-slate-800">Post Grades</p>
                    <p class="text-[11px] text-slate-400 font-medium mt-0.5">Quizzes & exams</p>
                </div>
                <div class="flex items-center gap-1 text-amber-600 text-xs font-semibold">
                    Enter grades
                    <svg class="w-3.5 h-3.5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>

            {{-- Total Students stat --}}
            <div class="glass-card p-6 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-sky-500 uppercase tracking-wider">Total</span>
                </div>
                <p class="text-3xl font-black text-slate-800 mt-1">{{ $totalStudents }}</p>
                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest">My Students</p>
            </div>

            {{-- Attendance % stat --}}
            <div class="glass-card p-6 flex flex-col gap-2">
                <div class="flex items-center justify-between">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <span class="text-[11px] font-bold text-indigo-500 uppercase tracking-wider">30-Day</span>
                </div>
                <p class="text-3xl font-black text-slate-800 mt-1">{{ $avgAttendance }}<span class="text-lg text-slate-400">%</span></p>
                <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest">Avg. Attendance</p>
            </div>
        </div>

        {{-- ── MAIN CONTENT GRID ── --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

            {{-- Left 2/3: Today's Schedule & Handled Subjects --}}
            <div class="xl:col-span-2 space-y-6">

                {{-- Today's Class Alert (Shown only if a class starts within 30 mins) --}}
                @php
                    $currentTime = now();
                    $upcomingClass = $todayClasses->first(function($class) use ($currentTime) {
                        $startTime = \Carbon\Carbon::parse($class->start_time);
                        $diffInMinutes = $currentTime->diffInMinutes($startTime, false);
                        return $diffInMinutes > 0 && $diffInMinutes <= 30;
                    });
                @endphp

                @if($upcomingClass && !isset($todayHoliday))
                    <div class="glass-card p-6 border-l-4 border-l-amber-500 bg-amber-50/40 relative overflow-hidden animate-pulse">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-black text-amber-900 text-lg">Class Starting Soon!</h3>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-700 bg-amber-200/50 px-2 py-1 rounded-lg">Alert</span>
                                </div>
                                <p class="text-amber-800 text-sm mt-1">
                                    Your class <span class="font-bold underline">{{ $upcomingClass->subject->name }}</span> starts at 
                                    <span class="font-black">{{ date('h:i A', strtotime($upcomingClass->start_time)) }}</span> in Room 
                                    <span class="font-black">{{ $upcomingClass->room }}</span>.
                                </p>
                                <div class="mt-4 flex items-center gap-3">
                                    <a href="{{ route('teacher.scanner', ['subject_id' => $upcomingClass->subject_id]) }}" 
                                       class="px-5 py-2 bg-amber-600 text-white text-xs font-bold rounded-xl shadow-lg shadow-amber-200 hover:bg-amber-700 transition-all">
                                        Open Attendance Scanner
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- My Schedule (Today's Class Schedule) --}}
                <div class="glass-card overflow-hidden">
                    <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between {{ isset($todayHoliday) ? 'bg-amber-50/30' : 'bg-emerald-50/30' }}">
                        <div>
                            <h2 class="text-base font-bold text-slate-800">My Schedule</h2>
                            <p class="text-xs text-slate-400 mt-0.5">Your classes for today, {{ now()->format('l, F j') }}</p>
                        </div>
                        @if(isset($todayHoliday))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-wider">
                                Holiday
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-wider">
                                <span class="relative flex h-2 w-2">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                </span>
                                Live Updates
                            </span>
                        @endif
                    </div>
                    <div class="p-6">
                        @if(isset($todayHoliday))
                            <div class="py-12 text-center bg-amber-50/50 rounded-3xl border border-dashed border-amber-200">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                    <svg class="w-8 h-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                </div>
                                <h5 class="text-lg font-black text-amber-900 leading-tight">Today is a Holiday!</h5>
                                <p class="text-sm text-amber-700 font-bold mt-1">{{ $todayHoliday->name }}</p>
                                <p class="text-[13px] text-amber-600 mt-2">Go ahead and enjoy your break. All active classes are suspended for today.</p>
                            </div>
                        @else
                            @forelse($todayClasses ?? [] as $schedule)
                                <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 rounded-2xl bg-white border border-slate-100 hover:border-emerald-200 hover:shadow-md transition-all mb-3 last:mb-0 group">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 text-emerald-600 flex items-center justify-center font-black text-lg shadow-sm group-hover:scale-110 transition-transform">
                                                {{ substr($schedule->subject->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $schedule->subject->name }}</h4>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500 uppercase tracking-tight">{{ $schedule->subject->code }}</span>
                                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-50 text-emerald-600 uppercase tracking-tight">{{ $schedule->section }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-6 sm:border-l sm:border-slate-100 sm:pl-6 shrink-0">
                                        <div class="text-left sm:text-right">
                                            <div class="flex items-center gap-1.5 text-slate-700 mb-1">
                                                <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <p class="text-xs font-black">{{ date('h:i A', strtotime($schedule->start_time)) }} - {{ date('h:i A', strtotime($schedule->end_time)) }}</p>
                                            </div>
                                            <div class="flex items-center gap-1.5 text-slate-400 justify-start sm:justify-end">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <p class="text-[10px] font-bold uppercase tracking-wider">Room: {{ $schedule->room }}</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('teacher.scanner', ['subject_id' => $schedule->subject_id]) }}" 
                                           class="w-11 h-11 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center hover:bg-emerald-600 hover:text-white transition-all shadow-sm group/btn"
                                           title="Scan Attendance">
                                            <svg class="w-5 h-5 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center bg-slate-50/50 rounded-3xl border border-dashed border-slate-200">
                                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                        <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <h5 class="text-sm font-bold text-slate-800">Clear Skies!</h5>
                                    <p class="text-xs text-slate-400 mt-1">You have no classes scheduled for today.</p>
                                </div>
                            @endforelse
                        @endif
                    </div>
                </div>

                {{-- Handled Subjects --}}
                <div class="glass-card overflow-hidden">
                    <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="text-base font-bold text-slate-800">Handled Subjects</h2>
                        <span class="text-xs font-bold text-slate-400">{{ $subjects->count() }} Total</span>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        @forelse($subjects as $subject)
                            <div class="p-4 rounded-2xl border border-slate-100 bg-white hover:border-violet-200 hover:shadow-md transition-all group">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center font-bold text-lg group-hover:bg-violet-600 group-hover:text-white transition-colors">
                                        {{ substr($subject->name, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-bold text-slate-800 truncate">{{ $subject->name }}</h4>
                                        <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">{{ $subject->code }}</p>
                                    </div>
                                </div>
                                <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                        </svg>
                                        <span class="text-xs font-bold text-slate-600">{{ $subject->students->count() }} Students</span>
                                    </div>
                                    <a href="{{ route('teacher.roster.subject', $subject->id) }}" class="text-[11px] font-black text-violet-600 hover:underline">Manage</a>
                                </div>
                            </div>
                        @empty
                             <p class="text-sm text-slate-400 col-span-2 text-center py-4 italic">No subjects handled yet.</p>
                        @endforelse
                    </div>
                </div>

            {{-- Right 1/3 --}}
            <div class="space-y-5">

                {{-- Recent Attendance Activity --}}
                <div class="glass-card overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-800">Attendance Activity</h3>
                        <a href="{{ route('teacher.attendance') }}"
                           class="text-[11px] font-semibold text-sky-500 hover:text-sky-600 transition-colors">View All</a>
                    </div>
                    <div class="divide-y divide-slate-100/70">
                        @forelse($recentAttendance as $record)
                            <div class="px-6 py-4 flex items-center gap-4">
                                @php
                                    $statusIcons = [
                                        'present' => ['bg' => 'bg-emerald-100 text-emerald-600', 'icon' => 'M5 13l4 4L19 7'],
                                        'late'    => ['bg' => 'bg-amber-100 text-amber-600',  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                                        'absent'  => ['bg' => 'bg-rose-100 text-rose-600',   'icon' => 'M6 18L18 6M6 6l12 12'],
                                    ];
                                    $si = $statusIcons[$record->status] ?? $statusIcons['absent'];
                                @endphp
                                <div class="w-9 h-9 rounded-xl {{ $si['bg'] }} flex items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $si['icon'] }}"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $record->student->user->name }}</p>
                                    <p class="text-[11px] text-slate-400">{{ $record->subject->code }} • {{ $record->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <p class="text-xs text-slate-400 font-medium">No recent records.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Grades --}}
                <div class="glass-card overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-800">Recent Grades</h3>
                        <a href="{{ route('teacher.grades.index') }}"
                           class="text-[11px] font-semibold text-amber-500 hover:text-amber-600 transition-colors">View All</a>
                    </div>
                    <div class="divide-y divide-slate-100/70">
                        @forelse($recentGrades as $grade)
                            <div class="px-6 py-4 flex items-center gap-4">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center shrink-0">
                                    <span class="text-[11px] font-black text-slate-600">{{ $grade->grade }}</span>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-slate-800 truncate">{{ $grade->student->user->name }}</p>
                                    <p class="text-[11px] text-slate-400 capitalize">{{ $grade->grade_type }} • {{ $grade->subject->code }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-8 text-center">
                                <p class="text-xs text-slate-400 font-medium">No grades posted yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
