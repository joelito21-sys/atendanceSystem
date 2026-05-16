<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                My Academic <span class="text-gradient">Performance</span>
            </h2>
            <p class="text-slate-500 mt-1">Track your progress and weighted grades</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Filters -->
        <div class="p-6 bg-white rounded-2xl border border-slate-100 shadow-sm">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Subject</label>
                    <select name="subject_id" class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Type</label>
                    <select name="type" class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50">
                        <option value="">All Types</option>
                        @foreach(App\Models\Grade::getTypes() as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Period</label>
                    <select name="grading_period" class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50">
                        <option value="">All Periods</option>
                        @foreach(App\Models\Grade::getGradingPeriods() as $period)
                            <option value="{{ $period }}" {{ request('grading_period') == $period ? 'selected' : '' }}>
                                {{ $period }} Period
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full premium-button-primary h-[42px]">
                        Filter Results
                    </button>
                </div>
            </form>
        </div>

        <!-- Weighted Summaries -->
        <div class="space-y-4">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                <div class="w-2 h-4 bg-sky-500 rounded-full"></div>
                Partial Grade Breakdowns
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($subjects as $subject)
                    @if(isset($weightedGrades[$subject->id]))
                        @php $summary = $weightedGrades[$subject->id]; @endphp
                        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-4">
                                <div class="max-w-[70%]">
                                    <h4 class="text-sm font-bold text-slate-800 truncate">{{ $subject->name }}</h4>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">{{ $subject->code }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="text-2xl font-black text-sky-600">{{ $summary['final'] }}</span>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Final %</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Attendance (20%)</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $summary['attendance'] }}%</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Oral (20%)</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $summary['oral'] }}%</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Quizzes (30%)</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $summary['quiz'] }}%</p>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase">Exams (30%)</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $summary['exam'] }}%</p>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Grade History -->
        <div class="space-y-4">
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                <div class="w-2 h-4 bg-indigo-500 rounded-full"></div>
                Individual Grade Records
            </h3>
            <div class="overflow-hidden bg-white rounded-2xl border border-slate-100 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Date / Subject</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Type / Title</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Raw Score</th>
                                <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Period</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($grades as $grade)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-[10px] font-bold text-slate-400 uppercase">{{ $grade->date_given->format('M d, Y') }}</div>
                                        <div class="text-sm font-bold text-slate-800">{{ $grade->subject->name ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase tracking-widest border border-indigo-100">
                                            {{ $grade->type }}
                                        </span>
                                        <div class="text-xs font-bold text-slate-500 mt-1 uppercase">{{ $grade->title }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-black 
                                                @if($grade->score / $grade->total_score >= 0.9) text-emerald-600
                                                @elseif($grade->score / $grade->total_score >= 0.8) text-sky-600
                                                @elseif($grade->score / $grade->total_score >= 0.75) text-amber-600
                                                @else text-rose-600
                                                @endif">
                                                {{ number_format($grade->score, 1) }}
                                            </span>
                                            <span class="text-xs text-slate-400 font-bold">/ {{ number_format($grade->total_score, 0) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-bold text-slate-600">{{ $grade->grading_period }} Period</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="text-slate-300 mb-2">
                                            <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">No matching records found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($grades->hasPages())
                    <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
                        {{ $grades->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
