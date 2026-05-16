<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Course <span class="text-gradient">Programs</span>
                </h2>
                <p class="text-slate-500 mt-1">Manage academic programs and curriculum roots</p>
            </div>
            <a href="{{ route('admin.courses.create') }}" class="premium-button-primary">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Course
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif
        
        @if(session('error'))
            <x-alert type="error" :message="session('error')" />
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($courses as $course)
                <div class="glass-card hover-lift group relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-sky-500/5 rounded-full transition-transform group-hover:scale-110"></div>
                    
                    <div class="flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-3 py-1 rounded-lg bg-sky-50 text-sky-600 text-xs font-bold uppercase tracking-wider border border-sky-100">
                                {{ $course->code }}
                            </span>
                            <div class="flex gap-2">
                                <a href="{{ route('admin.courses.edit', $course) }}" class="p-2 text-slate-400 hover:text-sky-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this course?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2H9a2 2 0 00-2 2v3m13 0H4" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-sky-600 transition-colors">
                            {{ $course->name }}
                        </h3>
                        
                        <p class="text-slate-500 text-sm line-clamp-2 mb-6 flex-grow">
                            {{ $course->description ?: 'No description provided.' }}
                        </p>

                        <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Active Subjects</span>
                                <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded text-xs font-bold">{{ $course->subjects_count }}</span>
                            </div>
                            <a href="{{ route('admin.courses.show', $course) }}" class="text-sky-500 font-bold text-sm hover:underline flex items-center gap-1">
                                Details
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center glass-card">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.168.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">No courses found</h3>
                    <p class="text-slate-500 mb-6">Get started by creating your first academic program.</p>
                    <a href="{{ route('admin.courses.create') }}" class="premium-button-primary inline-flex">
                        Add New Course
                    </a>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div class="mt-8">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
