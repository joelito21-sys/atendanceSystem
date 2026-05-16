<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-1">Parent Portal</p>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                    Welcome, <span class="text-gradient">{{ Auth::user()->name }}</span> 👨‍👩‍👧‍👦
                </h1>
                <p class="text-slate-500 mt-1 text-sm">
                    Monitoring
                    <span class="font-semibold text-slate-700">{{ count($childrenData) }}</span>
                    {{ count($childrenData) === 1 ? 'child' : 'children' }}'s academic progress.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-7">

        @if(count($childrenData) > 0)

            {{-- ── OVERVIEW STATS ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <div class="glass-card p-6 flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-800">{{ count($childrenData) }}</p>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest mt-0.5">Registered Children</p>
                    </div>
                </div>

                <div class="glass-card p-6 flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        @php
                            $rates = collect($childrenData)->pluck('attendance_rate')->filter();
                            $avgRate = $rates->count() ? round($rates->avg(), 1) : 0;
                        @endphp
                        <p class="text-3xl font-black text-slate-800">{{ $avgRate }}<span class="text-lg text-slate-400">%</span></p>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest mt-0.5">Avg. Attendance Rate</p>
                    </div>
                </div>

                <div class="glass-card p-6 flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-slate-800">
                            {{ collect($childrenData)->sum('subject_count') }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest mt-0.5">Total Enrolled Subjects</p>
                    </div>
                </div>
            </div>

            {{-- ── CHILDREN CARDS GRID ── --}}
            <div class="glass-card overflow-hidden">
                <div class="px-7 py-5 border-b border-slate-100">
                    <h2 class="text-base font-bold text-slate-800">My Children — Academic Overview</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Click on a child to view detailed records</p>
                </div>

                <div class="p-7 grid grid-cols-1 lg:grid-cols-2 gap-6">
                    @foreach($childrenData as $data)
                        @php
                            $student        = $data['student'];
                            $attendanceRate = $data['attendance_rate'];
                            $averageGrade   = $data['average_grade'];
                            $subjCount      = $data['subject_count'];
                            $recentAbsences = $data['recent_absences'];

                            // Rate color
                            $rateColor = $attendanceRate >= 90
                                ? 'text-emerald-600 bg-emerald-50'
                                : ($attendanceRate >= 75
                                    ? 'text-amber-600 bg-amber-50'
                                    : 'text-rose-600 bg-rose-50');
                        @endphp

                        <div class="p-6 rounded-3xl bg-white border border-slate-100 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group">

                            {{-- Student Header --}}
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-2xl font-black text-white shadow-lg group-hover:scale-105 transition-transform shrink-0">
                                    {{ substr($student->user->name ?? 'S', 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-lg font-black text-slate-800 truncate">{{ $student->user->name ?? 'Unknown' }}</h4>
                                    <div class="flex items-center gap-2 mt-1.5 flex-wrap">
                                        <span class="px-2.5 py-1 rounded-lg bg-indigo-100 text-indigo-700 text-[11px] font-bold">{{ $student->grade_level ?? 'N/A' }}</span>
                                        <span class="px-2.5 py-1 rounded-lg bg-slate-100 text-slate-600 text-[11px] font-semibold">Section {{ $student->section ?? 'N/A' }}</span>
                                        <span class="px-2.5 py-1 rounded-lg bg-sky-100 text-sky-700 text-[11px] font-semibold">{{ $subjCount }} subjects</span>
                                    </div>
                                </div>
                            </div>

                            {{-- Key Metrics --}}
                            <div class="grid grid-cols-3 gap-3 mb-5">
                                <div class="p-3.5 rounded-2xl {{ $rateColor }} text-center">
                                    <p class="text-xl font-black">{{ $attendanceRate }}%</p>
                                    <p class="text-[10px] font-bold uppercase tracking-wide mt-0.5 opacity-70">Attendance</p>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-indigo-50 text-indigo-700 text-center">
                                    <p class="text-xl font-black">{{ $averageGrade !== null ? $averageGrade : '—' }}</p>
                                    <p class="text-[10px] font-bold uppercase tracking-wide mt-0.5 opacity-70">Avg. Grade</p>
                                </div>
                                <div class="p-3.5 rounded-2xl bg-rose-50 text-rose-700 text-center">
                                    <p class="text-xl font-black">{{ $recentAbsences->count() }}</p>
                                    <p class="text-[10px] font-bold uppercase tracking-wide mt-0.5 opacity-70">Absences</p>
                                </div>
                            </div>

                            {{-- Quick Actions --}}
                            <div class="flex items-center gap-3">
                                <a href="{{ route('parent.child.attendance', $student->id) }}"
                                   class="flex-1 py-2.5 rounded-2xl bg-indigo-600 text-white text-xs font-semibold text-center hover:bg-indigo-700 transition-colors">
                                    Attendance
                                </a>
                                <a href="{{ route('parent.child.grades', $student->id) }}"
                                   class="flex-1 py-2.5 rounded-2xl bg-slate-100 text-slate-700 text-xs font-semibold text-center hover:bg-slate-200 transition-colors">
                                    Grades
                                </a>
                                <a href="{{ route('parent.child.show', $student->id) }}"
                                   class="py-2.5 px-4 rounded-2xl border border-slate-200 text-slate-500 text-xs font-semibold hover:bg-slate-50 transition-colors">
                                    Details
                                </a>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>

            {{-- ── QUICK NAVIGATION ── --}}
            <div class="glass-card p-7">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-5">Quick Navigation</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    <a href="{{ route('announcements.index') }}"
                       class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-sky-50 hover:border-sky-200 border border-slate-100 transition-all group">
                        <div class="w-11 h-11 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-sky-700">Announcements</p>
                            <p class="text-[11px] text-slate-400">School notices & updates</p>
                        </div>
                    </a>

                    <a href="{{ route('notifications.index') }}"
                       class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-indigo-50 hover:border-indigo-200 border border-slate-100 transition-all group">
                        <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 group-hover:text-indigo-700">Notifications</p>
                            <p class="text-[11px] text-slate-400">Activity alerts</p>
                        </div>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 border border-slate-100 transition-all group">
                        <div class="w-11 h-11 rounded-xl bg-slate-200 text-slate-600 flex items-center justify-center group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800">My Profile</p>
                            <p class="text-[11px] text-slate-400">Account settings</p>
                        </div>
                    </a>
                </div>
            </div>

        @else
            {{-- Empty State --}}
            <div class="glass-card p-16 text-center">
                <div class="w-20 h-20 rounded-3xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">No Children Linked</h3>
                <p class="text-slate-500 text-sm max-w-sm mx-auto">No student accounts are linked to your profile yet. Please contact the school administrator to set this up.</p>
            </div>
        @endif

    </div>
</x-app-layout>
