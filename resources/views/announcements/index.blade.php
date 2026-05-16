<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Bulletin <span class="text-gradient">Board</span>
                </h2>
                <p class="text-slate-500 mt-1">Stay updated with the latest campus news and alerts</p>
            </div>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('announcements.create') }}" class="premium-button-primary">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Post Announcement
                </a>
            @endif
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        <div class="grid gap-6">
            @forelse($announcements as $announcement)
                <div class="glass-card overflow-hidden border-l-4 {{ $announcement->priority === 'high' ? 'border-rose-500' : ($announcement->priority === 'medium' ? 'border-amber-500' : 'border-sky-500') }} relative group">
                    <div class="p-8">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-bold text-slate-800 tracking-tight mb-1 group-hover:text-indigo-600 transition-colors">
                                    {{ $announcement->title }}
                                </h3>
                                <div class="flex items-center gap-3 text-xs font-bold uppercase tracking-widest text-slate-400">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $announcement->creator->name ?? 'System' }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $announcement->created_at->format('M d, Y') }}</span>
                                    @if($announcement->target_role)
                                        <span>•</span>
                                        <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-500">For {{ $announcement->target_role }}s</span>
                                    @endif
                                </div>
                            </div>
                            
                            @if(auth()->user()->role === 'admin')
                                <div class="flex space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('announcements.edit', $announcement) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors bg-white/50 rounded-lg border border-slate-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" onsubmit="return confirm('Delete this announcement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors bg-white/50 rounded-lg border border-slate-100">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2H9a2 2 0 00-2 2v3m13 0H4"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        
                        <div class="text-slate-600 leading-relaxed text-lg max-w-4xl">
                            {!! nl2br(e($announcement->content)) !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 glass-card">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">No active announcements</h3>
                    <p class="text-slate-500">Check back later for campus news and updates.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $announcements->links() }}
        </div>
    </div>
</x-app-layout>

