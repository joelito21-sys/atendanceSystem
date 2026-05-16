<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'AttendanceSystem') }}</title>
        <meta name="description" content="A modern attendance management system for schools and institutions.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="bg-mesh min-h-screen antialiased overflow-x-hidden" x-data="{ collapsed: false }">
        <x-animated-bg />
        <x-sidebar />

        {{-- Main Wrapper: extra gap so header text never sits under collapsed sidebar --}}
        <div class="relative flex flex-col min-h-screen transition-all duration-300 ml-0" @verbatim :class="collapsed ? 'sm:ml-28' : 'sm:ml-72'" @endverbatim>
            {{-- Top Navigation Bar --}}
            @include('layouts.navigation')

            {{-- Page Heading --}}
            @isset($header)
                <div class="px-6 sm:px-10 pt-8 pb-4">
                    <div class="flex flex-col gap-1">
                        {{ $header }}
                    </div>
                </div>
            @endisset

            {{-- Alerts --}}
            <div class="px-6 sm:px-10 mt-4">
                @if(session('success'))
                    <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-800 rounded-2xl flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <p class="text-sm font-semibold">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-100 text-rose-800 rounded-2xl">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm font-bold">Please check the following errors:</p>
                        </div>
                        <ul class="list-disc list-inside text-xs font-medium space-y-1 pl-8">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            <main class="flex-1 px-6 sm:px-10 pb-12 pt-2">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

            {{-- Footer --}}
            <footer class="px-4 sm:px-10 py-5 border-t border-slate-200/60 flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                <p class="text-xs text-slate-400 font-medium order-2 sm:order-1">
                    &copy; {{ date('Y') }} <span class="font-semibold text-slate-500">AttendanceSystem</span>. All rights reserved.
                </p>
                <p class="text-xs text-slate-400 order-1 sm:order-2">{{ now()->format('l, F j, Y') }}</p>
            </footer>
        </div>

    </body>
</html>
