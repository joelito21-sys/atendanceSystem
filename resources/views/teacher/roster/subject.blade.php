<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex flex-col gap-1">
                <nav class="flex text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 gap-2">
                    <a href="{{ route('teacher.roster.index') }}" class="hover:text-sky-500 transition-colors">My Students</a>
                    <span>/</span>
                    <span class="text-slate-600">{{ $subject->code }}</span>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ $subject->name }} <span class="text-gradient">Roster</span>
                </h2>
                <p class="text-slate-500">Manage students for this specific subject and section</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('teacher.grades.bulk-create', ['subject_id' => $subject->id]) }}" class="premium-button-secondary">
                    Bulk Grade Entry
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[10px] font-black text-slate-400">
                            <th class="px-6 py-4">Student Name</th>
                            <th class="px-6 py-4">Student ID</th>
                            <th class="px-6 py-4">Level & Section</th>
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
                                    <div class="text-sm text-slate-600 font-medium">Year {{ $student->grade_level }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $student->section }}</div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('teacher.grades.create', ['student_id' => $student->id, 'subject_id' => $subject->id]) }}" class="p-2 text-slate-400 hover:text-amber-600 transition-colors bg-white rounded-lg border border-slate-100 shadow-sm" title="Post Grade">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <p class="text-slate-500">No students enrolled in this subject.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
