<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Academic <span class="text-gradient">Performance</span>
            </h2>
            <p class="text-slate-500 mt-1">{{ $student->user->name }}'s academic record</p>
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

        <!-- Overall Average -->
        <div class="bg-gradient-to-br from-sky-600 to-blue-800 rounded-3xl shadow-xl shadow-sky-100 p-8 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-10">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
            </div>
            <div class="relative z-10 text-center sm:text-left">
                <p class="text-xs font-black text-sky-100 uppercase tracking-[0.2em]">Overall Grade Point Average</p>
                <div class="flex flex-col sm:flex-row items-center gap-6 mt-4">
                    <p class="text-7xl font-black tracking-tighter">
                        {{ $overallAverage ? number_format($overallAverage, 2) : 'N/A' }}
                    </p>
                    <div class="h-12 w-px bg-white/20 hidden sm:block"></div>
                    @if($overallAverage)
                        <div class="flex flex-col">
                            <span class="text-xl font-bold text-white">
                                @if($overallAverage >= 90)
                                    Excellent Standing 🌟
                                @elseif($overallAverage >= 80)
                                    Commendable Performance 👍
                                @elseif($overallAverage >= 75)
                                    Good Standing 📚
                                @else
                                    Support Needed 💪
                                @endif
                            </span>
                            <span class="text-sky-100 text-sm font-medium mt-1">Based on current semester data</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Grades by Subject -->
        <div class="space-y-8">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                <div class="w-2 h-4 bg-sky-500 rounded-full"></div>
                Detailed Subject Breakdown
            </h3>
            
            @forelse($gradesBySubject as $subjectData)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden group hover:border-sky-200 transition-all duration-300">
                    <!-- Subject Header -->
                    <div class="bg-slate-50/50 px-6 py-5 border-b border-slate-100">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-white border border-slate-200 flex items-center justify-center text-sky-600 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-800 tracking-tight">{{ $subjectData['subject']->name }}</h3>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $subjectData['subject']->code }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Subject Average</p>
                                <p class="text-3xl font-black text-sky-600 tabular-nums">
                                    {{ number_format($subjectData['average'], 2) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Weighted Breakdown -->
                    <div class="px-6 py-4 bg-sky-50/30 border-b border-slate-100 grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Attendance (20%)</p>
                            <p class="text-sm font-bold text-slate-700">{{ $subjectData['weighted']['attendance'] }}% <span class="text-[10px] text-slate-400 font-normal">pts: {{ $subjectData['weighted']['weights']['attendance'] }}</span></p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Oral (20%)</p>
                            <p class="text-sm font-bold text-slate-700">{{ $subjectData['weighted']['oral'] }}% <span class="text-[10px] text-slate-400 font-normal">pts: {{ $subjectData['weighted']['weights']['oral'] }}</span></p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Quizzes (30%)</p>
                            <p class="text-sm font-bold text-slate-700">{{ $subjectData['weighted']['quiz'] }}% <span class="text-[10px] text-slate-400 font-normal">pts: {{ $subjectData['weighted']['weights']['quiz'] }}</span></p>
                        </div>
                        <div>
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Exams (30%)</p>
                            <p class="text-sm font-bold text-slate-700">{{ $subjectData['weighted']['exam'] }}% <span class="text-[10px] text-slate-400 font-normal">pts: {{ $subjectData['weighted']['weights']['exam'] }}</span></p>
                        </div>
                    </div>

                    <!-- Grades Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-white">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Evaluation</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Raw Score</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Remarks</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($subjectData['grades'] as $grade)
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest border border-slate-200 w-fit">
                                                    {{ $grade->type }}
                                                </span>
                                                <span class="text-xs font-bold text-slate-800 mt-1 uppercase">{{ $grade->title }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <div class="flex items-center gap-2">
                                                    <span class="text-lg font-black 
                                                        @if(($grade->score / $grade->total_score) >= 0.9) text-emerald-600
                                                        @elseif(($grade->score / $grade->total_score) >= 0.8) text-sky-600
                                                        @elseif(($grade->score / $grade->total_score) >= 0.75) text-amber-600
                                                        @else text-rose-600
                                                        @endif">
                                                        {{ number_format($grade->score, 2) }}
                                                    </span>
                                                    <span class="text-xs text-slate-400 font-bold">/ {{ number_format($grade->total_score, 0) }}</span>
                                                </div>
                                                <span class="text-[10px] font-bold text-slate-300">{{ round(($grade->score / $grade->total_score) * 100, 1) }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-xs font-medium text-slate-500 italic">
                                            {{ $grade->remarks ?? 'No remarks provided.' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-[10px] font-bold text-slate-400 uppercase">
                                            {{ $grade->date_given->format('M d, Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl border border-slate-100 p-16 text-center shadow-sm">
                    <div class="w-20 h-20 rounded-3xl bg-slate-50 text-slate-300 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-lg font-black text-slate-800 uppercase tracking-tight">No Academic Records Yet</h4>
                    <p class="text-slate-400 text-sm mt-1 max-w-xs mx-auto">Grades will appear here as soon as the teacher posts them for any subject.</p>
                </div>
            @endforelse
        </div>

        <!-- Grade Legend -->
        @if($gradesBySubject->count() > 0)
            <div class="bg-slate-900 rounded-3xl p-8 text-white">
                <h3 class="text-xs font-black text-sky-400 uppercase tracking-[0.3em] mb-6">Department Grading Scale Reference</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-black text-lg">A</div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5">90 - 100</p>
                            <p class="text-sm font-bold">Excellent Standing</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-sky-500/20 text-sky-400 flex items-center justify-center font-black text-lg">B</div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5">80 - 89</p>
                            <p class="text-sm font-bold">Very Good Standing</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-black text-lg">C</div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5">75 - 79</p>
                            <p class="text-sm font-bold">Good Standing</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-black text-lg">F</div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-0.5">Below 75</p>
                            <p class="text-sm font-bold text-rose-300">Needs Improvement</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
