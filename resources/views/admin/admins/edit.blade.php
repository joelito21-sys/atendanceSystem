<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Edit <span class="text-gradient">Administrator</span>
            </h2>
            <p class="text-slate-500">Update account details for {{ $admin->name }}</p>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.admins.update', $admin) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="glass-card shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-sky-500"></div>
                
                <div class="p-8 space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                        <x-text-input name="name" value="{{ old('name', $admin->name) }}" required class="w-full" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Address</label>
                        <x-text-input type="email" name="email" value="{{ old('email', $admin->email) }}" required class="w-full" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex items-center gap-2 mb-4">
                            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Update Password</h3>
                            <span class="text-[10px] text-slate-400 font-bold">(Optional)</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">New Password</label>
                                <x-text-input type="password" name="password" class="w-full" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Confirm New Password</label>
                                <x-text-input type="password" name="password_confirmation" class="w-full" />
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-400">Leave blank if you don't want to change the password.</p>
                    </div>
                </div>

                <div class="bg-slate-50/80 p-6 flex justify-end items-center gap-4 border-t border-slate-100">
                    <a href="{{ route('admin.admins.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 px-4 py-2">
                        Cancel
                    </a>
                    <button type="submit" class="premium-button-primary px-12">
                        Update Account
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
