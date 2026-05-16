<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Grade <span class="text-gradient">Management</span>
            </h2>
            <p class="text-slate-500 mt-1">Manage student grades for your subjects</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Actions -->
        <div class="flex justify-end gap-3">
            <a href="{{ route('teacher.grades.create') }}" 
               class="premium-button-primary flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Grade
            </a>
            <a href="{{ route('teacher.grades.bulk-create') }}" 
               class="premium-button-secondary flex items-center border-sky-200 text-sky-700 hover:bg-sky-50">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Bulk Entry
            </a>
        </div>

        <!-- Filters -->
        <div class="p-6 bg-slate-50/50 rounded-2xl border border-slate-100">
            <form method="GET" action="{{ route('teacher.grades.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Subject</label>
                    <select name="subject_id" class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-white">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Grade Type</label>
                    <select name="type" class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-white">
                        <option value="">All Types</option>
                        @foreach(App\Models\Grade::getTypes() as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Student</label>
                    <input type="text" name="student_search" value="{{ request('student_search') }}" 
                           placeholder="Search student..." 
                           class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-white shadow-sm">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full premium-button-primary shadow-sky-100 h-[42px]">
                        Filter Records
                    </button>
                </div>
            </form>
        </div>

        @if(!empty($weightedSummaries))
            <!-- Partial Grade Summary -->
            <div class="space-y-4">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                    <div class="w-2 h-4 bg-sky-500 rounded-full"></div>
                    Partial Grade Summaries (Subject Average)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($weightedSummaries as $studentId => $summary)
                        @php $student = App\Models\Student::find($studentId); @endphp
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">{{ $student->user->name }}</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $student->student_id }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-black text-sky-600">{{ $summary['final'] }}</span>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Final %</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Attendance (20%)</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $summary['attendance'] }}% <span class="text-slate-300 font-normal">({{ $summary['weights']['attendance'] }})</span></p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Oral (20%)</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $summary['oral'] }}% <span class="text-slate-300 font-normal">({{ $summary['weights']['oral'] }})</span></p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Quizzes (30%)</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $summary['quiz'] }}% <span class="text-slate-300 font-normal">({{ $summary['weights']['quiz'] }})</span></p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Exams (30%)</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $summary['exam'] }}% <span class="text-slate-300 font-normal">({{ $summary['weights']['exam'] }})</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Grades Table -->
        <div class="overflow-hidden bg-white rounded-2xl border border-slate-100 shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Student</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Subject</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Type</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Grade</th>
                            <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Date</th>
                            <th class="px-6 py-4 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($grades as $grade)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-bold">
                                            {{ substr($grade->student->user->name ?? 'S', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-slate-800">{{ $grade->student->user->name ?? 'N/A' }}</div>
                                            <div class="text-[10px] font-bold text-slate-400 uppercase">{{ $grade->student->student_id }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-slate-600">{{ $grade->subject->name ?? 'N/A' }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">{{ $grade->subject->code ?? '' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100">
                                        {{ $grade->type }}
                                    </span>
                                    <div class="text-[9px] font-bold text-slate-400 mt-1 uppercase">{{ $grade->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-black 
                                                @if($grade->score / $grade->total_score >= 0.9) text-emerald-600
                                                @elseif($grade->score / $grade->total_score >= 0.8) text-sky-600
                                                @elseif($grade->score / $grade->total_score >= 0.75) text-amber-600
                                                @else text-rose-600
                                                @endif">
                                                {{ number_format($grade->score, 2) }}
                                            </span>
                                            <span class="text-xs text-slate-400 font-bold">/ {{ number_format($grade->total_score, 0) }}</span>
                                        </div>
                                        <div class="text-[10px] font-black text-slate-300 uppercase tracking-tighter">
                                            {{ round(($grade->score / $grade->total_score) * 100, 1) }}%
                                        </div>
                                    </div>
                                </td>
                                        @if($grade->remarks)
                                            <div class="group relative">
                                                <svg class="w-4 h-4 text-slate-400 cursor-help" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <div class="hidden group-hover:block absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-48 p-2 bg-slate-800 text-white text-[10px] rounded-lg shadow-xl z-10">
                                                    {{ $grade->remarks }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs font-medium text-slate-400 uppercase">
                                    {{ $grade->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('teacher.grades.edit', $grade) }}" 
                                           class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <form action="{{ route('teacher.grades.destroy', $grade) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition-colors" 
                                                    onclick="return confirm('Are you sure you want to delete this grade?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-50 text-slate-300 flex items-center justify-center">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-slate-400">No grades found. Click "Add Grade" to create one.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($grades->hasPages())
                <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                    {{ $grades->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
