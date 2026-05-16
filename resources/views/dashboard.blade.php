<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">
            <span class="text-gradient">Dashboard</span> Overview
        </h2>
    </x-slot>

    <div class="space-y-6 sm:space-y-10">
        <div class="relative overflow-hidden rounded-2xl sm:rounded-3xl bg-slate-900 p-5 sm:p-8 text-white shadow-2xl">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-sky-500/20 blur-3xl"></div>
            <div class="absolute -bottom-20 -left-20 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl"></div>
            
            <div class="relative z-10">
                <h3 class="text-xl sm:text-3xl font-black mb-2">Welcome back, {{ auth()->user()->name }}! 🚀</h3>
                <p class="text-slate-400 max-w-xl text-sm sm:text-base">Everything is running smoothly! Here’s a quick look at today's attendance metrics and system activity.</p>
                
                <div class="mt-6 sm:mt-8 flex flex-wrap gap-3 sm:gap-4">
                    <div class="px-6 py-3 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 inline-flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-sm font-bold">System Online</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
            {{-- Stat Card 1 --}}
            <div class="glass-card group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex items-start justify-between mb-6">
                    <div class="p-3 rounded-2xl bg-sky-100 text-sky-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-black text-sky-500 bg-sky-50 px-3 py-1 rounded-full uppercase tracking-tighter">+12% vs last month</span>
                </div>
                <div class="text-slate-500 font-bold uppercase text-xs tracking-widest mb-1">Total Students</div>
                <div class="text-4xl sm:text-5xl font-black text-slate-800 tabular-nums tracking-tighter">1,280</div>
            </div>

            {{-- Stat Card 2 --}}
            <div class="glass-card group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex items-start justify-between mb-6">
                    <div class="p-3 rounded-2xl bg-emerald-100 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-black text-emerald-500 bg-emerald-50 px-3 py-1 rounded-full uppercase tracking-tighter">On Track</span>
                </div>
                <div class="text-slate-500 font-bold uppercase text-xs tracking-widest mb-1">Present Today</div>
                <div class="text-4xl sm:text-5xl font-black text-slate-800 tabular-nums tracking-tighter">942</div>
            </div>

            {{-- Stat Card 3 --}}
            <div class="glass-card group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex items-start justify-between mb-6">
                    <div class="p-3 rounded-2xl bg-rose-100 text-rose-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-black text-rose-500 bg-rose-50 px-3 py-1 rounded-full uppercase tracking-tighter">Review Needed</span>
                </div>
                <div class="text-slate-500 font-bold uppercase text-xs tracking-widest mb-1">Late/Absent</div>
                <div class="text-4xl sm:text-5xl font-black text-slate-800 tabular-nums tracking-tighter">338</div>
            </div>
        </div>
    </div>


</x-app-layout>
