<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Edit <span class="text-gradient">Grade</span>
            </h2>
            <p class="text-slate-500 mt-1">Update grade information for {{ $grade->student->user->name }}</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('teacher.grades.index') }}" class="premium-button bg-white text-slate-600 hover:text-sky-600 flex items-center w-fit border border-slate-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Grades
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl p-8">
            <form action="{{ route('teacher.grades.update', $grade) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Student Info (Read-only) -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Student</label>
                        <p class="text-sm font-bold text-slate-800">{{ $grade->student->user->name ?? 'N/A' }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $grade->student->student_id }}</p>
                    </div>

                    <!-- Subject Info (Read-only) -->
                    <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Subject</label>
                        <p class="text-sm font-bold text-slate-800">{{ $grade->subject->name ?? 'N/A' }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $grade->subject->code }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Title / Description <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" required
                               value="{{ old('title', $grade->title) }}"
                               class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50 @error('title') border-rose-500 @enderror"
                               placeholder="e.g. Unit Quiz 1, Final Exam, Class Participation">
                        @error('title')
                            <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grading Period -->
                    <div>
                        <label for="grading_period" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Period <span class="text-rose-500">*</span>
                        </label>
                        <select id="grading_period" name="grading_period" required
                                class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50">
                            @foreach(App\Models\Grade::getGradingPeriods() as $period)
                                <option value="{{ $period }}" {{ old('grading_period', $grade->grading_period) == $period ? 'selected' : '' }}>{{ $period }} Period</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Grade Type -->
                    <div>
                        <label for="type" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Type <span class="text-rose-500">*</span>
                        </label>
                        <select id="type" name="type" required
                                class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50 @error('type') border-rose-500 @enderror">
                            @foreach(App\Models\Grade::getTypes() as $type)
                                <option value="{{ $type }}" {{ old('type', $grade->type) == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Score -->
                    <div>
                        <label for="score" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Score <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="score" name="score" step="0.01" required
                               value="{{ old('score', $grade->score) }}"
                               class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50 @error('score') border-rose-500 @enderror"
                               placeholder="0.00">
                        @error('score')
                            <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Total Score -->
                    <div>
                        <label for="total_score" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Total <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="total_score" name="total_score" step="0.01" required
                               value="{{ old('total_score', $grade->total_score) }}"
                               class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50 @error('total_score') border-rose-500 @enderror"
                               placeholder="100">
                        @error('total_score')
                            <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date_given" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="date_given" name="date_given" required
                               value="{{ old('date_given', $grade->date_given->format('Y-m-d')) }}"
                               class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50 @error('date_given') border-rose-500 @enderror">
                        @error('date_given')
                            <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Remarks -->
                <div>
                    <label for="remarks" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                        Remarks (Optional)
                    </label>
                    <textarea id="remarks" name="remarks" rows="2"
                              class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50 @error('remarks') border-rose-500 @enderror"
                              placeholder="Add any comments or remarks...">{{ old('remarks', $grade->remarks) }}</textarea>
                    @error('remarks')
                        <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-6 border-t border-slate-50">
                    <a href="{{ route('teacher.grades.index') }}" 
                       class="premium-button bg-slate-100 text-slate-600 hover:bg-slate-200">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="premium-button-primary shadow-sky-100">
                        Update Grade Record
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
