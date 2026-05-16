<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.pre-enrollments.index') }}" class="p-2 rounded-lg hover:bg-slate-100 text-slate-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Enrollment <span class="text-gradient">Details</span>
                </h2>
                <p class="text-slate-500 mt-1"> viewing record for {{ $preEnrollment->student_id_number }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="glass-card p-8">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-center text-sky-600 font-bold text-2xl">
                        {{ substr($preEnrollment->student_name, 0, 1) }}
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-slate-900">{{ $preEnrollment->student_name }}</h3>
                        <p class="text-slate-500 font-medium">{{ $preEnrollment->student_email }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.pre-enrollments.edit', $preEnrollment) }}" class="premium-button-secondary py-2 px-4 text-sm">
                        Edit Record
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Academic Info -->
                <div class="space-y-6">
                    <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Academic Information</h4>
                    
                    <div class="mb-4">
                        <span class="text-xs font-semibold text-slate-400 uppercase">Student ID</span>
                        <p class="text-lg font-bold text-slate-700">{{ $preEnrollment->student_id_number }}</p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50/50">
                                    <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">Subject</th>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">Section</th>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest">Term</th>
                                    <th class="px-4 py-3 text-xs font-bold text-slate-500 uppercase tracking-widest text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($studentEnrollments as $enrollment)
                                    <tr class="hover:bg-slate-50 transition-colors">
                                        <td class="px-4 py-3 text-sm font-bold text-slate-700">{{ $enrollment->subject_code }}</td>
                                        <td class="px-4 py-3 text-sm text-slate-600">{{ $enrollment->section ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-xs text-slate-500">
                                            {{ $enrollment->school_year }} | {{ ucfirst($enrollment->semester) }}
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <form action="{{ route('admin.pre-enrollments.destroy', $enrollment) }}" method="POST" class="inline" onsubmit="return confirm('Remove this subject?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs transition-colors">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Guardian Info -->
                <div class="space-y-6">
                    <h4 class="text-sm font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 pb-2">Guardian Contact</h4>
                    
                    <div>
                        <span class="text-xs font-semibold text-slate-400 uppercase">Parent Email</span>
                        <div class="flex items-center gap-2 mt-1">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <p class="text-base font-medium text-slate-700">{{ $preEnrollment->parent_email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>
    </div>
</x-app-layout>
