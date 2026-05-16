<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Edit <span class="text-gradient">Enrollment Entry</span>
            </h2>
            <p class="text-slate-500">Modify an existing automated enrollment rule</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.pre-enrollments.update', $preEnrollment) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <div class="glass-card shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-sky-500"></div>
                
                <div class="p-8 space-y-8">
                    @if ($errors->any())
                        <div class="bg-red-50 text-red-600 p-4 rounded-lg text-sm mb-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Basic Info Section --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">1</span>
                            <h3 class="text-lg font-bold text-slate-800">Basic Information</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Student ID Number</label>
                                <x-text-input name="student_id_number" value="{{ old('student_id_number', $preEnrollment->student_id_number) }}" required class="w-full" />
                                <x-input-error :messages="$errors->get('student_id_number')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Subject</label>
                                <select name="subject_code" required class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 shadow-sm bg-white/50 py-2.5 transition-all">
                                    <option value="">-- Select Subject --</option>
                                    @foreach($subjects as $subject)
                                        <option value="{{ $subject->code }}" {{ old('subject_code', $preEnrollment->subject_code) == $subject->code ? 'selected' : '' }}>
                                            {{ $subject->name }} ({{ $subject->code }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('subject_code')" class="mt-2" />
                            </div>
                        </div>
                    </section>

                    <hr class="border-slate-100">

                    {{-- Assignment Details Section --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">2</span>
                            <h3 class="text-lg font-bold text-slate-800">Assignment Details</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Section</label>
                                <x-text-input name="section" value="{{ old('section', $preEnrollment->section) }}" required placeholder="e.g. Einstein" class="w-full" />
                                <x-input-error :messages="$errors->get('section')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">School Year</label>
                                <x-text-input name="school_year" value="{{ old('school_year', $preEnrollment->school_year) }}" required class="w-full" />
                                <x-input-error :messages="$errors->get('school_year')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Semester</label>
                                <x-text-input name="semester" value="{{ old('semester', $preEnrollment->semester) }}" required placeholder="e.g. 1st Semester" class="w-full" />
                                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Footer / Actions --}}
                <div class="bg-slate-50/80 p-6 flex flex-col sm:flex-row justify-end items-center gap-4">
                    <a href="{{ route('admin.pre-enrollments.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 px-4 py-2">
                        Cancel
                    </a>
                    <button type="submit" class="premium-button-primary w-full sm:w-auto px-12">
                        Update Entry
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>
