<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Email <span class="text-gradient">History</span>
            </h2>
            <p class="text-slate-500 mt-1">Monitor all sent notifications and their status</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        <div class="glass-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[10px] font-black text-slate-400">
                            <th class="px-6 py-4">Recipient</th>
                            <th class="px-6 py-4">Subject</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Sent At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($logs as $log)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-700">{{ $log->recipient_email }}</div>
                                    <div class="text-[10px] text-slate-400 font-bold uppercase tracking-wide">
                                        Parent of {{ $log->student->user->name ?? 'Unknown Student' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-slate-600 font-medium">{{ $log->subject }}</div>
                                    <div class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded inline-block font-bold uppercase mt-1">{{ $log->type }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($log->status === 'sent')
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Sent
                                        </span>
                                    @elseif($log->status === 'failed')
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-lg text-xs font-bold bg-rose-50 text-rose-600 border border-rose-100" title="{{ $log->error_message }}">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            Failed
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 py-1 px-2 rounded-lg text-xs font-bold bg-slate-50 text-slate-600 border border-slate-100">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-slate-500 text-sm font-medium">
                                    {{ $log->created_at->format('M d, H:i') }}
                                    <div class="text-[10px] text-slate-400">{{ $log->created_at->diffForHumans() }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-20 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-800">No email history</h3>
                                    <p class="text-slate-500">Scheduled notifications will appear here once processed.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>
</x-app-layout>
