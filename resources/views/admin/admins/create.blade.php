<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Add <span class="text-gradient">Administrator</span>
            </h2>
            <p class="text-slate-500">Assign full system access to a new user</p>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            
            <div class="glass-card shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sky-500 to-indigo-500"></div>
                
                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                        <x-text-input name="name" value="{{ old('name') }}" required placeholder="e.g. John Doe" class="w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                        <x-text-input type="email" name="email" value="{{ old('email') }}" required placeholder="admin@example.com" class="w-full" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Set Password</label>
                            <x-text-input type="password" name="password" required class="w-full" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Confirm Password</label>
                            <x-text-input type="password" name="password_confirmation" required class="w-full" />
                        </div>
                    </div>

                    <div class="bg-indigo-50/50 rounded-2xl p-6 border border-indigo-100/50 flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-indigo-900 mb-1">Privilege Notice</p>
                            <p class="text-sm text-indigo-700 leading-relaxed">Administrator accounts have full control over students, teachers, grades, and system settings. Do not share these credentials.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-slate-50/80 p-6 flex justify-end items-center gap-4 border-t border-slate-100">
                    <a href="{{ route('admin.admins.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 px-4 py-2">
                        Cancel
                    </a>
                    <button type="submit" class="premium-button-primary px-12">
                        Create Admin Account
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
