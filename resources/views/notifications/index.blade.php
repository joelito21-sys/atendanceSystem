<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                    Your <span class="text-gradient">Notifications</span>
                </h2>
                <p class="text-slate-500 mt-1">Manage your activity alerts and system updates</p>
            </div>
            <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center gap-2 px-4 py-2 rounded-xl hover:bg-indigo-50 leading-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Mark all as read
                </button>
            </form>
        </div>
    </x-slot>

    <div class="space-y-4">
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        <div class="glass-card divide-y divide-slate-100 overflow-hidden">
            @forelse($notifications as $notification)
                <div class="p-6 transition-all hover:bg-slate-50/50 flex justify-between items-start gap-6 {{ $notification->read_at ? 'opacity-60' : 'bg-indigo-50/10' }}">
                    <div class="flex-1 flex gap-4">
                        <div class="flex-shrink-0 mt-1">
                            @if($notification->type === 'warning')
                                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                            @elseif($notification->type === 'error')
                                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @elseif($notification->type === 'success')
                                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @else
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-lg font-bold text-slate-800 leading-tight">{{ $notification->title }}</h3>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-slate-600 mb-3 leading-relaxed">{{ $notification->message }}</p>
                            @if($notification->link)
                                <a href="{{ $notification->link }}" class="text-sm font-bold text-indigo-500 hover:text-indigo-700 hover:underline">View Related Records &rarr;</a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        @unless($notification->read_at)
                            <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 text-slate-400 hover:text-emerald-600 transition-colors bg-white rounded-lg border border-slate-100 title="Mark as read">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </button>
                            </form>
                        @endunless
                        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Remove this notification?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors bg-white rounded-lg border border-slate-100" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2H9a2 2 0 00-2 2v3m13 0H4"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-20 text-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Clear Skies</h3>
                    <p class="text-slate-500">You have no new notifications at this time.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-8">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>

