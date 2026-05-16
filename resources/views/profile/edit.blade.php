<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-slate-900 tracking-tight">
             User <span class="text-gradient">Profile</span>
        </h2>
    </x-slot>

    <div class="space-y-8 max-w-4xl">
        <div class="glass-card shadow-xl">
            <div class="max-w-xl">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Profile Information</h3>
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="glass-card shadow-xl">
            <div class="max-w-xl">
                <h3 class="text-xl font-bold text-slate-800 mb-6">Update Password</h3>
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="glass-card shadow-xl !border-rose-100 !bg-rose-50/10">
            <div class="max-w-xl">
                <h3 class="text-xl font-bold text-rose-600 mb-6">Danger Zone</h3>
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

</x-app-layout>
