<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Edit <span class="text-gradient">Course Program</span>
            </h2>
            <p class="text-slate-500">Modify program details and identification</p>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <form action="{{ route('admin.courses.update', $course) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="glass-card shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-sky-500"></div>
                
                <div class="p-8 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Program Name</label>
                            <x-text-input name="name" value="{{ old('name', $course->name) }}" required class="w-full" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Course Code</label>
                            <x-text-input name="code" value="{{ old('code', $course->code) }}" required class="w-full" />
                            <x-input-error :messages="$errors->get('code')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Description</label>
                        <textarea name="description" rows="4" class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 shadow-sm bg-white/50 transition-all">{{ old('description', $course->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div class="bg-slate-50/80 p-6 flex justify-end items-center gap-4 border-t border-slate-100">
                    <a href="{{ route('admin.courses.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 px-4 py-2">
                        Cancel
                    </a>
                    <button type="submit" class="premium-button-primary px-12">
                        Update Program
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
