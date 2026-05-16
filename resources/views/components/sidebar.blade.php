@props(['drawer' => false])

@if($drawer)
    {{-- Drawer mode: nav + user block only (for mobile menu) --}}
    <div class="flex flex-col flex-1 overflow-y-auto px-4 py-4 min-h-0">
@else
<aside class="fixed top-0 left-0 z-40 h-screen flex flex-col -translate-x-full sm:translate-x-0 transition-all duration-300 flex-shrink-0"
       @verbatim :class="collapsed ? 'w-20' : 'w-72'" @endverbatim
       style="background: rgba(255,255,255,0.92); backdrop-filter: blur(20px); border-right: 1px solid rgba(226,232,240,0.8);">

    {{-- Logo / Brand + Toggle --}}
    <div class="relative flex items-center gap-3 h-16 border-b border-slate-200/60 shrink-0 px-3 min-w-0" x-bind:class="collapsed ? 'justify-center !px-0' : ''">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center shadow-lg shadow-sky-200 shrink-0">
            <x-application-logo class="w-5 h-5 fill-white" />
        </div>
        <div class="min-w-0 flex-1" x-show="!collapsed" x-transition>
            <span class="text-base font-bold text-slate-800 leading-tight tracking-tight block truncate">AttendanceSystem</span>
            <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold">Management Portal</p>
        </div>
        <button type="button"
                @click="collapsed = !collapsed"
                class="absolute -right-3 top-1/2 -translate-y-1/2 shrink-0 p-1 bg-white border border-slate-200 rounded-full text-slate-400 hover:text-sky-600 shadow-sm transition-transform z-50 flex items-center justify-center"
                aria-label="Toggle sidebar">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" :class="collapsed && 'rotate-180'">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>

    {{-- Navigation Links --}}
@endif
    <div class="flex-1 overflow-y-auto px-4 py-5 space-y-1">

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Dashboard</span>
        </a>

        {{-- ── ADMIN LINKS ── --}}
        @if(auth()->user()->role === 'admin')
        <div class="pt-5 pb-2" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
            <p class="px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Records</p>
        </div>

        <a href="{{ route('admin.students.index') }}"
           class="{{ request()->routeIs('admin.students.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Student Records</span>
        </a>

        <a href="{{ route('admin.teachers.index') }}"
           class="{{ request()->routeIs('admin.teachers.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Teacher Records</span>
        </a>

        <a href="{{ route('admin.parents.index') }}"
           class="{{ request()->routeIs('admin.parents.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Parent Directory</span>
        </a>

        <div class="pt-5 pb-2" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
            <p class="px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Academic</p>
        </div>

        <a href="{{ route('admin.courses.index') }}"
           class="{{ request()->routeIs('admin.courses.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Course Programs</span>
        </a>

        <a href="{{ route('admin.subjects.index') }}"
           class="{{ request()->routeIs('admin.subjects.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Subjects</span>
        </a>

        <a href="{{ route('admin.pre-enrollments.index') }}"
           class="{{ request()->routeIs('admin.pre-enrollments.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Master Enrollment</span>
        </a>

        <div class="pt-5 pb-2" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
            <p class="px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">System</p>
        </div>

        <a href="{{ route('admin.holidays.index') }}"
           class="{{ request()->routeIs('admin.holidays.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Manage Holidays</span>
        </a>

        <a href="{{ route('admin.admins.index') }}"
           class="{{ request()->routeIs('admin.admins.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Manage Admins</span>
        </a>

        <a href="{{ route('admin.email-logs.index') }}"
           class="{{ request()->routeIs('admin.email-logs.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Email History</span>
        </a>

        <a href="{{ route('admin.settings.index') }}"
           class="{{ request()->routeIs('admin.settings.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11.049 2.927c.3-1.14 1.978-1.14 2.278 0l.317 1.205a1 1 0 00.95.735h1.27c1.178 0 1.665 1.51.788 2.218l-1.028.822a1 1 0 00-.333 1.063l.39 1.204c.35 1.084-.89 1.986-1.81 1.31l-1.03-.748a1 1 0 00-1.176 0l-1.03.748c-.92.676-2.16-.226-1.81-1.31l.39-1.204a1 1 0 00-.333-1.063l-1.028-.822c-.877-.708-.39-2.218.788-2.218h1.27a1 1 0 00.95-.735l.317-1.205z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>System Settings</span>
        </a>
        @endif

        {{-- ── TEACHER LINKS ── --}}
        @if(auth()->user()->role === 'teacher')
        <div class="pt-5 pb-2" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
            <p class="px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Attendance</p>
        </div>

        <a href="{{ route('teacher.scanner') }}"
           class="{{ request()->routeIs('teacher.scanner') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>QR Scanner</span>
        </a>

        <a href="{{ route('teacher.attendance') }}"
           class="{{ request()->routeIs('teacher.attendance') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Attendance Logs</span>
        </a>

        <div class="pt-5 pb-2" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
            <p class="px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Academics</p>
        </div>

        <a href="{{ route('teacher.grades.index') }}"
           class="{{ request()->routeIs('teacher.grades.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Grade Records</span>
        </a>

        <a href="{{ route('teacher.roster.index') }}"
           class="{{ request()->routeIs('teacher.roster.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>My Students</span>
        </a>

        <a href="{{ route('teacher.pre-enrollments.index') }}"
           class="{{ request()->routeIs('teacher.pre-enrollments.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Student Enrollment</span>
        </a>
        @endif

        {{-- ── STUDENT LINKS ── --}}
        @if(auth()->user()->role === 'student')
        <div class="pt-5 pb-2" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
            <p class="px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">My Academics</p>
        </div>

        <a href="{{ route('student.attendance') }}"
           class="{{ request()->routeIs('student.attendance') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>My Attendance</span>
        </a>

        <a href="{{ route('student.grades') }}"
           class="{{ request()->routeIs('student.grades') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>My Grades</span>
        </a>

        <a href="{{ route('student.qr-code') }}"
           class="{{ request()->routeIs('student.qr-code') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>My QR Code</span>
        </a>
        @endif

        {{-- ── PARENT LINKS ── --}}
        @if(auth()->user()->role === 'parent')
        <div class="pt-5 pb-2" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
            <p class="px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">My Children</p>
        </div>

        <a href="{{ route('parent.child-attendance') }}"
           class="{{ request()->routeIs('parent.child-attendance') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Child Attendance</span>
        </a>

        <a href="{{ route('parent.child-grades') }}"
           class="{{ request()->routeIs('parent.child-grades') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Child Grades</span>
        </a>
        @endif

        {{-- ── SHARED LINKS ── --}}
        <div class="pt-5 pb-2" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
            <p class="px-5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">General</p>
        </div>

        <a href="{{ route('announcements.index') }}"
           class="{{ request()->routeIs('announcements.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Announcements</span>
        </a>

        <a href="{{ route('notifications.index') }}"
           class="{{ request()->routeIs('notifications.*') ? 'sidebar-link-active' : 'sidebar-link' }}">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Notifications</span>
        </a>

    </div>

    {{-- Bottom: User Profile Area --}}
    <div class="px-4 py-4 border-t border-slate-200/60 shrink-0">
        <div class="flex items-center gap-3 px-2 py-2 rounded-2xl hover:bg-slate-100 transition-all group cursor-pointer mb-2">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md shrink-0">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="min-w-0 flex-1" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
                <p class="text-sm font-semibold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-slate-400 truncate capitalize">{{ auth()->user()->role }}</p>
            </div>
            <a href="{{ route('profile.edit') }}" class="text-slate-400 hover:text-sky-500 transition-colors shrink-0" @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full flex items-center gap-3 px-5 py-3 rounded-2xl text-sm font-medium text-rose-500 hover:bg-rose-50 hover:text-rose-600 transition-all">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span @if(!$drawer) @verbatim x-show="!collapsed" x-transition @endverbatim @endif>Sign Out</span>
            </button>
        </form>
    </div>

@if($drawer)
    </div>
@else
</aside>
@endif
