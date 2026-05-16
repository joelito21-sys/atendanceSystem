<x-app-layout>
    <x-slot name="header">
        @if($student)
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-violet-500 uppercase tracking-widest mb-1">Student Portal</p>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                    Hello, <span class="text-gradient">{{ $student->user->name ?? 'Student' }}</span> ✨
                </h1>
                <div class="flex items-center gap-3 mt-2 flex-wrap">
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-bold">
                        {{ $student->grade_level }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold">
                        Section {{ $student->section }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                        ID: {{ $student->student_id_number }}
                    </span>
                </div>
            </div>
            <a href="{{ route('student.qr-code') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 text-white text-sm font-semibold rounded-2xl shadow-lg shadow-violet-100 hover:bg-violet-700 hover:-translate-y-0.5 transition-all duration-200 self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                </svg>
                My QR Code
            </a>
        </div>
        @else
        <h1 class="text-3xl font-black text-slate-900">Student Portal</h1>
        @endif
    </x-slot>

    <div class="space-y-7">

        @if(!$student)
            {{-- Profile not set up --}}
            <div class="glass-card p-8 border border-amber-200 bg-amber-50/50">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-amber-800">Profile Not Set Up</h3>
                        <p class="text-sm text-amber-700 mt-1">Your student profile has not been configured yet. Please contact the school administrator.</p>
                    </div>
                </div>
            </div>
        @else

            {{-- ── ATTENDANCE STAT CARDS ── --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

                @php
                    $totalDays = ($attendanceStats['present'] ?? 0) + ($attendanceStats['late'] ?? 0) + ($attendanceStats['absent'] ?? 0);
                @endphp

                {{-- Days Present --}}
                <div class="glass-card p-6 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/8 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">Present</span>
                    </div>
                    <p class="text-3xl font-black text-slate-800">{{ $attendanceStats['present'] ?? 0 }}</p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Days attended</p>
                </div>

                {{-- Days Late --}}
                <div class="glass-card p-6 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-amber-500/8 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-amber-500 bg-amber-50 px-2 py-1 rounded-lg">Late</span>
                    </div>
                    <p class="text-3xl font-black text-slate-800">{{ $attendanceStats['late'] ?? 0 }}</p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Tardiness instances</p>
                </div>

                {{-- Days Absent --}}
                <div class="glass-card p-6 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-br from-rose-500/8 to-transparent opacity-0 group-hover:opacity-100 transition-opacity rounded-[2rem]"></div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-11 h-11 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-rose-500 bg-rose-50 px-2 py-1 rounded-lg">Absent</span>
                    </div>
                    <p class="text-3xl font-black text-slate-800">{{ $attendanceStats['absent'] ?? 0 }}</p>
                    <p class="text-xs text-slate-400 font-medium mt-1">Days missed</p>
                </div>

                {{-- Attendance Rate --}}
                <div class="glass-card p-6 bg-gradient-to-br from-violet-600 to-indigo-700 text-white relative overflow-hidden">
                    <div class="absolute right-0 top-0 w-24 h-24 rounded-full bg-white/5 -translate-y-6 translate-x-6"></div>
                    <div class="flex items-center justify-between mb-4 relative z-10">
                        <div class="w-11 h-11 rounded-2xl bg-white/20 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <span class="text-xs font-bold text-violet-200 bg-white/10 px-2 py-1 rounded-lg">Rate</span>
                    </div>
                    <p class="text-3xl font-black relative z-10">{{ $attendanceStats['percentage'] ?? 0 }}<span class="text-xl text-violet-200">%</span></p>
                    <p class="text-xs text-violet-200 font-medium mt-1 relative z-10">Attendance rate</p>
                </div>
            </div>

            {{-- ── MAIN CONTENT GRID ── --}}
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

                {{-- Left: Today's Schedule + Active Subjects --}}
                <div class="xl:col-span-2 space-y-6">
                    
                    {{-- Today's Class Schedule --}}
                    <div class="glass-card overflow-hidden">
                        <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between {{ isset($todayHoliday) ? 'bg-amber-50/30' : 'bg-violet-50/30' }}">
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Today's Class Schedule</h2>
                                <p class="text-xs text-slate-400 mt-0.5">{{ now()->format('l, F j, Y') }}</p>
                            </div>
                            @if(isset($todayHoliday))
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-[10px] font-black uppercase tracking-wider">
                                    Holiday
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-[10px] font-black uppercase tracking-wider">
                                    <span class="relative flex h-2 w-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-violet-500"></span>
                                    </span>
                                    Today
                                </span>
                            @endif
                        </div>
                        <div class="p-6">
                            @if(isset($todayHoliday))
                                <div class="py-8 text-center bg-amber-50/50 rounded-3xl border border-dashed border-amber-200">
                                    <svg class="w-10 h-10 mx-auto text-amber-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                    </svg>
                                    <p class="text-sm font-bold text-amber-700 mb-1">Today is a Holiday!</p>
                                    <p class="text-[13px] text-amber-600 font-medium italic">{{ $todayHoliday->name }}</p>
                                    <p class="text-[11px] text-amber-500 mt-2">All classes are suspended for today.</p>
                                </div>
                            @else
                                @forelse($todayClasses ?? [] as $schedule)
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 rounded-2xl bg-white border border-slate-100 hover:border-violet-200 hover:shadow-md transition-all mb-3 last:mb-0 group">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center font-bold">
                                                    {{ substr($schedule->subject->name, 0, 1) }}
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-slate-800 group-hover:text-violet-600 transition-colors">{{ $schedule->subject->name }}</h4>
                                                    <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider">{{ $schedule->subject->code }} &bull; {{ $schedule->section }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-6 sm:border-l sm:border-slate-100 sm:pl-6 shrink-0">
                                            <div class="text-left sm:text-right">
                                                <p class="text-xs font-bold text-slate-700">{{ date('h:i A', strtotime($schedule->start_time)) }} - {{ date('h:i A', strtotime($schedule->end_time)) }}</p>
                                                <p class="text-[10px] text-slate-400 font-medium">Room: {{ $schedule->room }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="shrink-0 hidden sm:block">
                                            <svg class="w-5 h-5 text-slate-200 group-hover:text-violet-400 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-8 text-center bg-slate-50/50 rounded-3xl border border-dashed border-slate-200">
                                        <svg class="w-10 h-10 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <p class="text-sm text-slate-400 font-medium italic">No classes scheduled for today.</p>
                                    </div>
                                @endforelse
                            @endif
                        </div>
                    </div>

                    {{-- Original Active Subjects Card --}}
                    <div class="glass-card overflow-hidden">
                        <div class="px-7 py-5 border-b border-slate-100 flex items-center justify-between">
                            <div>
                                <h2 class="text-base font-bold text-slate-800">Active Subjects</h2>
                                <p class="text-xs text-slate-400 mt-0.5">Your enrolled subjects this semester</p>
                            </div>
                            <a href="{{ route('student.attendance') }}"
                               class="inline-flex items-center gap-1.5 text-xs font-semibold text-sky-600 hover:text-sky-700 px-3 py-1.5 rounded-xl hover:bg-sky-50 transition-all">
                                View Attendance
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @forelse($subjects as $subject)
                                <div class="group p-5 rounded-2xl bg-slate-50 border border-slate-100 hover:border-violet-200 hover:bg-violet-50/20 transition-all">
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="min-w-0 flex-1">
                                            <h4 class="font-bold text-slate-800 leading-tight">{{ $subject->name }}</h4>
                                            <p class="text-[11px] text-slate-400 font-semibold uppercase tracking-wider mt-0.5">{{ $subject->code }}</p>
                                        </div>
                                    </div>
                                    <div class="space-y-2 mt-3">
                                        @if($subject->teacher)
                                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                <span class="font-medium">{{ $subject->teacher->user->name }}</span>
                                            </div>
                                        @endif
                                        @foreach($subject->classSchedules as $schedule)
                                            <div class="flex items-center gap-2 text-xs text-slate-500">
                                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>{{ substr($schedule->day_of_week, 0, 3) }} &bull; {{ date('h:i A', strtotime($schedule->start_time)) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-2 py-14 text-center">
                                    <svg class="w-10 h-10 mx-auto text-slate-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    <p class="text-sm text-slate-400 font-medium">No subjects enrolled yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Right: Grades + Quick Links --}}
                <div class="space-y-5">

                    {{-- Latest Grades --}}
                    <div class="glass-card overflow-hidden">
                        <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-slate-800">Latest Grades</h3>
                            <a href="{{ route('student.grades') }}"
                               class="text-[11px] font-semibold text-indigo-500 hover:text-indigo-600 transition-colors">View All</a>
                        </div>
                        <div class="divide-y divide-slate-100/70">
                            @forelse($recentGrades ?? [] as $grade)
                                <div class="px-6 py-4 flex items-start justify-between gap-3">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $grade->title }}</p>
                                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $grade->subject->code }} &bull; {{ ucfirst($grade->type) }}</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-sm font-black text-indigo-600">{{ $grade->score }}/{{ $grade->total_score }}</p>
                                        <p class="text-[11px] text-slate-400">{{ $grade->percentage }}%</p>
                                    </div>
                                </div>
                            @empty
                                <div class="px-6 py-10 text-center">
                                    <p class="text-sm text-slate-400 font-medium">No grades posted yet.</p>
                                </div>
                            @endforelse
                        </div>
                        <div class="px-6 py-4 border-t border-slate-100">
                            <a href="{{ route('student.grades') }}"
                               class="block text-center py-2.5 rounded-2xl bg-slate-100 text-slate-600 text-xs font-semibold hover:bg-slate-200 transition-colors">
                                Full Academic Records →
                            </a>
                        </div>
                    </div>

                    {{-- Quick Actions --}}
                    <div class="glass-card p-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Quick Access</h3>
                        <div class="space-y-2">
                            <a href="{{ route('student.qr-code') }}"
                               class="flex items-center gap-3 p-3.5 rounded-2xl hover:bg-violet-50 hover:text-violet-600 transition-all group text-slate-700">
                                <div class="w-9 h-9 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <svg class="w-4.5 h-4.5" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold">My QR Code</span>
                            </a>
                            <a href="{{ route('student.attendance') }}"
                               class="flex items-center gap-3 p-3.5 rounded-2xl hover:bg-sky-50 hover:text-sky-600 transition-all group text-slate-700">
                                <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <svg class="w-4.5 h-4.5" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold">My Attendance</span>
                            </a>
                            <a href="{{ route('student.attendance') }}"
                               class="flex items-center gap-3 p-3.5 rounded-2xl hover:bg-emerald-50 hover:text-emerald-600 transition-all group text-slate-700">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center group-hover:scale-105 transition-transform">
                                    <svg class="w-4.5 h-4.5" style="width:18px;height:18px" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-sm font-semibold">Attendance Logs</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        @endif
    </div>
</x-app-layout>
