<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                My <span class="text-gradient">Students</span>
            </h2>
            <p class="text-slate-500 mt-1">View all students enrolled in your subjects</p>
        </div>
    </x-slot>

    <div class="space-y-8">
        <!-- Subjects Filter Chips -->
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('teacher.roster.index') }}" class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ !request('subject_id') ? 'bg-sky-500 text-white shadow-lg shadow-sky-200' : 'bg-white text-slate-500 hover:bg-slate-50 border border-slate-100' }}">
                All Students
            </a>
            @foreach($subjects as $subject)
                <a href="{{ route('teacher.roster.subject', $subject) }}" class="px-4 py-2 rounded-xl text-sm font-bold bg-white text-slate-500 hover:bg-slate-50 border border-slate-100 transition-all hover-lift">
                    {{ $subject->code }}
                </a>
            @endforeach
        </div>

        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[10px] font-black text-slate-400">
                            <th class="px-6 py-4">Student Name</th>
                            <th class="px-6 py-4">Student ID</th>
                            <th class="px-6 py-4">Course / Level</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $student)
                            <tr class="hover:bg-slate-50/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xs group-hover:bg-sky-100 group-hover:text-sky-600 transition-colors">
                                            {{ strtoupper(substr($student->user->name, 0, 2)) }}
                                        </div>
                                        <div class="font-bold text-slate-700 group-hover:text-sky-600 transition-colors">{{ $student->user->name }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-slate-500">{{ $student->student_id_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-600 font-medium">{{ $student->course->name ?? 'N/A' }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Year {{ $student->grade_level }} • {{ $student->section }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('teacher.grades.create', ['student_id' => $student->id]) }}" class="p-2 text-slate-400 hover:text-amber-600 transition-colors bg-white rounded-lg border border-slate-100 shadow-sm" title="Post Grade">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">No students found</h3>
                                    <p class="text-slate-500">You don't have any students enrolled in your subjects yet.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
