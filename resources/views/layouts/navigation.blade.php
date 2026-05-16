<nav x-data="{ open: false, userOpen: false }" class="glass-nav px-5 sm:px-8 py-0 h-16 flex items-center justify-between gap-4 shadow-sm">

    {{-- Left: Mobile Toggle + Breadcrumb --}}
    <div class="flex items-center gap-4">
        {{-- Hamburger (mobile only) --}}
        <button @click="open = !open"
            class="sm:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-sky-600 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        {{-- Page context badge --}}
        <div class="hidden sm:flex items-center gap-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 text-xs font-semibold text-slate-600 capitalize">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                {{ ucfirst(auth()->user()->role ?? 'user') }} Portal
            </span>
        </div>
    </div>

    {{-- Center: Global Search (Admin Only) --}}
    @if(auth()->user()->role === 'admin')
    <div class="hidden sm:flex flex-1 max-w-lg mx-6">
        <form action="{{ route('admin.search') }}" method="GET" class="w-full relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="w-4 h-4 text-slate-400 group-focus-within:text-sky-500 transition-colors"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input type="text" name="query"
                   placeholder="Search students, teachers, subjects…"
                   value="{{ request('query') }}"
                   class="w-full bg-slate-100/70 border border-transparent focus:border-sky-400 focus:ring-4 focus:ring-sky-500/10 rounded-2xl pl-11 pr-10 py-2.5 text-sm font-medium transition-all duration-200 placeholder:text-slate-400 focus:bg-white">
            <button type="submit"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-sky-500 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </form>
    </div>
    @endif

    {{-- Right: Notifications + User Menu --}}
    <div class="flex items-center gap-2">

        {{-- Notification Bell (placeholder) --}}
        <a href="{{ route('notifications.index') }}"
           class="relative p-2.5 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-sky-600 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
        </a>

        {{-- User Dropdown --}}
        <x-dropdown align="right" width="56">
            <x-slot name="trigger">
                <button class="flex items-center gap-3 pl-2 pr-3 py-1.5 rounded-2xl hover:bg-slate-100 transition-all duration-200 group">
                    <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-md">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-sm font-semibold text-slate-800 leading-tight">{{ Auth::user()->name }}</p>
                        <p class="text-[11px] text-slate-400 font-medium capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <svg class="w-4 h-4 text-slate-400 group-hover:text-slate-600 transition-colors"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </x-slot>

            <x-slot name="content">
                <div class="px-4 py-3 border-b border-slate-100">
                    <p class="text-xs font-semibold text-slate-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                </div>
                <x-dropdown-link :href="route('profile.edit')">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ __('Profile Settings') }}
                    </div>
                </x-dropdown-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        <div class="flex items-center gap-2 text-rose-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            {{ __('Sign Out') }}
                        </div>
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

    {{-- Mobile Sidebar Slide-over --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-0 z-50 sm:hidden">
        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="open = false"></div>
        {{-- Drawer --}}
        <div class="relative w-72 h-full bg-white shadow-2xl overflow-y-auto flex flex-col">
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
                <div class="flex items-center gap-2.5">
                    <x-application-logo class="w-7 h-7 fill-sky-600" />
                    <span class="font-bold text-slate-800 text-lg tracking-tight">Attendance</span>
                </div>
                <button @click="open = false" class="p-2 -mr-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Mobile Search (Admin) --}}
            @if(auth()->user()->role === 'admin')
            <div class="px-4 py-4 border-b border-slate-100">
                <form action="{{ route('admin.search') }}" method="GET" class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="query" placeholder="Search…"
                           value="{{ request('query') }}"
                           class="w-full bg-slate-100 border border-transparent focus:border-sky-400 focus:ring-0 rounded-xl pl-10 pr-4 py-2.5 text-sm">
                </form>
            </div>
            @endif

            {{-- Full sidebar nav (same role-based links as desktop) --}}
            <x-sidebar :drawer="true" />
        </div>
    </div>

</nav>
