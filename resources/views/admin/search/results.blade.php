<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Search <span class="text-gradient">Results</span>
            </h2>
            <p class="text-slate-500 mt-1">Found results for: <span class="font-bold text-slate-800">"{{ $query }}"</span></p>
        </div>
    </x-slot>

    <div class="space-y-8">
        @php $hasResults = false; @endphp

        <!-- Students Section -->
        @if($results['students']->count() > 0)
            @php $hasResults = true; @endphp
            <section class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Students</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($results['students'] as $student)
                        <a href="{{ route('admin.students.show', $student) }}" class="glass-card p-4 flex items-center gap-4 hover-lift group border border-transparent hover:border-sky-200 transition-all">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-sky-50 group-hover:text-sky-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 group-hover:text-sky-600 transition-colors">{{ $student->user->name }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $student->student_id_number }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Teachers Section -->
        @if($results['teachers']->count() > 0)
            @php $hasResults = true; @endphp
            <section class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Teachers</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($results['teachers'] as $teacher)
                        <a href="{{ route('admin.teachers.show', $teacher) }}" class="glass-card p-4 flex items-center gap-4 hover-lift group border border-transparent hover:border-indigo-200 transition-all">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $teacher->user->name }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Subjects Section -->
        @if($results['subjects']->count() > 0)
            @php $hasResults = true; @endphp
            <section class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Subjects</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($results['subjects'] as $subject)
                        <a href="{{ route('admin.subjects.show', $subject) }}" class="glass-card p-4 flex items-center gap-4 hover-lift group border border-transparent hover:border-rose-200 transition-all">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-rose-50 group-hover:text-rose-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 group-hover:text-rose-600 transition-colors">{{ $subject->name }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $subject->code }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- Admins Section -->
        @if($results['admins']->count() > 0)
            @php $hasResults = true; @endphp
            <section class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 21a11.955 11.955 0 01-9.618-7.016m19.236 0A11.955 11.955 0 0112 3a11.955 11.955 0 019.618 7.016"></path></svg>
                    </div>
                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Administrators</h3>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($results['admins'] as $admin)
                        <a href="{{ route('admin.admins.edit', $admin) }}" class="glass-card p-4 flex items-center gap-4 hover-lift group border border-transparent hover:border-emerald-200 transition-all">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-emerald-50 group-hover:text-emerald-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <div class="font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $admin->name }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if(!$hasResults)
            <div class="text-center py-20 glass-card">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">No results found</h3>
                <p class="text-slate-500">We couldn't find any match for your search query.</p>
                <div class="mt-8 flex justify-center gap-4">
                    <a href="{{ route('dashboard') }}" class="premium-button-secondary">Back to Dashboard</a>
                    <a href="{{ route('admin.students.index') }}" class="premium-button-primary">View All Students</a>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
