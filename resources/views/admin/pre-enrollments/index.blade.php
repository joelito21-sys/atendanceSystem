<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Master <span class="text-gradient">Enrollment</span> List
                </h2>
                <p class="text-slate-500 mt-1">Manage automated subject enrollment rules</p>
            </div>
            <div class="flex gap-2">
                <form action="{{ route('admin.pre-enrollments.sync-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="premium-button-secondary" onclick="return confirm('This will ensure all student records match the master enrollment rules. Continue?')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Sync Records
                    </button>
                </form>
                <a href="{{ route('admin.pre-enrollments.create') }}" class="premium-button-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Entry
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center gap-3 animate-in fade-in slide-in-from-top-4 duration-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="glass-card overflow-hidden !p-0">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student ID</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Student Name</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest">Enrolled Subjects</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($preEnrollments as $pre)
                            <tr class="hover:bg-sky-50/30 transition-colors group">
                                <td class="px-6 py-4">
                                    <span class="font-bold text-slate-700">{{ $pre->student_id_number }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-semibold text-slate-800">{{ $pre->student_name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span class="px-3 py-1 rounded-full bg-sky-50 border border-sky-100 text-xs font-bold text-sky-600 shadow-sm">
                                            {{ $pre->subjects_count }} Subjects
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('admin.pre-enrollments.show', $pre) }}" class="px-3 py-1.5 rounded-lg bg-sky-50 text-sky-600 text-xs font-bold hover:bg-sky-100 transition-colors">
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </div>
                                        <p class="text-slate-500 font-medium">No enrollment rules found.</p>
                                        <a href="{{ route('admin.pre-enrollments.create') }}" class="mt-4 text-sky-500 font-bold hover:underline">Create your first rule</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($preEnrollments->hasPages())
                <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100">
                    {{ $preEnrollments->links() }}
                </div>
            @endif
        </div>
    </div>

</x-app-layout>
