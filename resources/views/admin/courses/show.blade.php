<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-sky-500 uppercase tracking-widest mb-1">Course Program</p>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                    {{ $course->name }}
                </h1>
                <p class="text-slate-500 mt-1 text-sm">Code: <span class="font-semibold text-slate-700">{{ $course->code }}</span></p>
            </div>
            <a href="{{ route('admin.courses.edit', $course) }}"
               class="premium-btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Course
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="glass-card p-6 sm:p-8">
            <h2 class="text-sm font-semibold text-slate-700 uppercase tracking-widest mb-3">Description</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                {{ $course->description ?: 'No description has been provided for this course yet.' }}
            </p>
        </div>

        <div class="glass-card overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Subjects under this course</h2>
                    <p class="text-xs text-slate-400 mt-0.5">All subjects linked to {{ $course->code }}</p>
                </div>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($course->subjects as $subject)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $subject->name }}</p>
                            <p class="text-[11px] text-slate-400 font-medium uppercase tracking-widest mt-0.5">{{ $subject->code }}</p>
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-12 text-center text-sm text-slate-400">
                        No subjects are currently linked to this course.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

