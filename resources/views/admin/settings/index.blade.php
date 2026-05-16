<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-sky-500 uppercase tracking-widest mb-1">System</p>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">
                    System <span class="text-gradient">Settings</span>
                </h1>
                <p class="text-slate-500 mt-1 text-sm">Configure global details like school name, term dates, and timezone.</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 max-w-5xl">
        @if(session('success'))
            <x-alert type="success" :message="session('success')" />
        @endif

        <div class="glass-card p-6 sm:p-8">
            <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- School Name --}}
                    <div class="space-y-1.5">
                        <label for="school_name" class="text-xs font-bold text-slate-600 uppercase tracking-widest">School Name</label>
                        <input
                            id="school_name"
                            type="text"
                            name="school_name"
                            class="w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm"
                            value="{{ old('school_name', optional($existing['school_name'] ?? null)->value ?? $definitions['school_name']['default']) }}"
                            placeholder="e.g. St. Mary Academy"
                        >
                        <p class="text-[11px] text-slate-400">{{ $definitions['school_name']['description'] }}</p>
                        @error('school_name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- School Year --}}
                    <div class="space-y-1.5">
                        <label for="school_year" class="text-xs font-bold text-slate-600 uppercase tracking-widest">School Year</label>
                        <input
                            id="school_year"
                            type="text"
                            name="school_year"
                            class="w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm"
                            value="{{ old('school_year', optional($existing['school_year'] ?? null)->value ?? $definitions['school_year']['default']) }}"
                            placeholder="e.g. 2025–2026"
                        >
                        <p class="text-[11px] text-slate-400">{{ $definitions['school_year']['description'] }}</p>
                        @error('school_year')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Term Start --}}
                    <div class="space-y-1.5">
                        <label for="term_start" class="text-xs font-bold text-slate-600 uppercase tracking-widest">Term Start</label>
                        <input
                            id="term_start"
                            type="date"
                            name="term_start"
                            class="w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm"
                            value="{{ old('term_start', optional($existing['term_start'] ?? null)->value ?? $definitions['term_start']['default']) }}"
                        >
                        <p class="text-[11px] text-slate-400">{{ $definitions['term_start']['description'] }}</p>
                        @error('term_start')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Term End --}}
                    <div class="space-y-1.5">
                        <label for="term_end" class="text-xs font-bold text-slate-600 uppercase tracking-widest">Term End</label>
                        <input
                            id="term_end"
                            type="date"
                            name="term_end"
                            class="w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm"
                            value="{{ old('term_end', optional($existing['term_end'] ?? null)->value ?? $definitions['term_end']['default']) }}"
                        >
                        <p class="text-[11px] text-slate-400">{{ $definitions['term_end']['description'] }}</p>
                        @error('term_end')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Contact Email --}}
                    <div class="space-y-1.5">
                        <label for="contact_email" class="text-xs font-bold text-slate-600 uppercase tracking-widest">Contact Email</label>
                        <input
                            id="contact_email"
                            type="email"
                            name="contact_email"
                            class="w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm"
                            value="{{ old('contact_email', optional($existing['contact_email'] ?? null)->value ?? $definitions['contact_email']['default']) }}"
                            placeholder="e.g. registrar@school.edu"
                        >
                        <p class="text-[11px] text-slate-400">{{ $definitions['contact_email']['description'] }}</p>
                        @error('contact_email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Timezone --}}
                    <div class="space-y-1.5">
                        <label for="timezone" class="text-xs font-bold text-slate-600 uppercase tracking-widest">Timezone</label>
                        <input
                            id="timezone"
                            type="text"
                            name="timezone"
                            class="w-full rounded-2xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 text-sm"
                            value="{{ old('timezone', optional($existing['timezone'] ?? null)->value ?? $definitions['timezone']['default']) }}"
                            placeholder="e.g. Asia/Manila"
                        >
                        <p class="text-[11px] text-slate-400">{{ $definitions['timezone']['description'] }}</p>
                        @error('timezone')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-end">
                    <button
                        type="submit"
                        class="premium-btn-primary"
                    >
                        Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

