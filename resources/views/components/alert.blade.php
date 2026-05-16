@props([
    'type'    => 'info',
    'message' => null,
])

@if($message)
@php
    $styles = [
        'success' => [
            'wrapper' => 'bg-emerald-50 border-emerald-200 text-emerald-800',
            'icon'    => 'text-emerald-500',
            'path'    => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'error' => [
            'wrapper' => 'bg-rose-50 border-rose-200 text-rose-800',
            'icon'    => 'text-rose-500',
            'path'    => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'warning' => [
            'wrapper' => 'bg-amber-50 border-amber-200 text-amber-800',
            'icon'    => 'text-amber-500',
            'path'    => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        ],
        'info' => [
            'wrapper' => 'bg-sky-50 border-sky-200 text-sky-800',
            'icon'    => 'text-sky-500',
            'path'    => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
    ];
    $s = $styles[$type] ?? $styles['info'];
@endphp

<div class="flex items-start gap-3 px-5 py-4 rounded-2xl border {{ $s['wrapper'] }}" role="alert">
    <svg class="w-5 h-5 shrink-0 mt-0.5 {{ $s['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s['path'] }}" />
    </svg>
    <p class="text-sm font-semibold leading-relaxed">{{ $message }}</p>
</div>
@endif
