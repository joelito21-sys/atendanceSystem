<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Bulk Grade <span class="text-gradient">Entry</span>
            </h2>
            <p class="text-slate-500 mt-1">Enter grades for multiple students at once</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('teacher.grades.index') }}" class="premium-button bg-white text-slate-600 hover:text-sky-600 flex items-center w-fit border border-slate-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Grades
            </a>
        </div>

        <!-- Tabs for Entry Method -->
        <div class="flex gap-4 p-1 bg-slate-100 rounded-2xl w-fit mb-6">
            <button onclick="toggleMethod('manual')" id="btn-manual" class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all bg-white text-sky-600 shadow-sm">
                Manual Sheet
            </button>
            <button onclick="toggleMethod('import')" id="btn-import" class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-slate-500 hover:text-slate-700">
                CSV Import
            </button>
        </div>

        <!-- Import Form (Hidden by default) -->
        <div id="import-section" class="hidden bg-white rounded-2xl border border-slate-100 shadow-xl p-8 mb-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Import from Spreadsheet</h3>
                    <p class="text-xs text-slate-400 mt-1">Upload a CSV file with student scores</p>
                </div>
                <a href="{{ route('teacher.grades.template', ['subject_id' => request('subject_id')]) }}" 
                   id="download-template-link"
                   class="text-[10px] font-black text-sky-600 uppercase tracking-widest hover:underline flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download Template {{ request('subject_id') ? '(Pre-filled)' : '' }}
                </a>
            </div>

            <form action="{{ route('teacher.grades.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Subject Selection -->
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Subject</label>
                        <select name="subject_id" required class="w-full rounded-xl border-slate-200 bg-slate-50/50">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grading Period -->
                    <div>
                        <label for="import_grading_period" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Period</label>
                        <select id="import_grading_period" name="grading_period" required class="w-full rounded-xl border-slate-200 bg-slate-50/50">
                            @foreach(App\Models\Grade::getGradingPeriods() as $period)
                                <option value="{{ $period }}" {{ old('grading_period') == $period ? 'selected' : '' }}>{{ $period }} Period</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="import_date_given" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Date</label>
                        <input type="date" id="import_date_given" name="date_given" required
                               value="{{ old('date_given', date('Y-m-d')) }}"
                               class="w-full rounded-xl border-slate-200 bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-1">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Record Title</label>
                        <input type="text" name="title" required class="w-full rounded-xl border-slate-200 bg-slate-50/50" placeholder="e.g. Summative Test 1">
                    </div>

                    <!-- Type -->
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Type</label>
                        <select name="type" required class="w-full rounded-xl border-slate-200 bg-slate-50/50">
                            @foreach(App\Models\Grade::getTypes() as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Total Score -->
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Points Possible</label>
                        <input type="number" name="total_score" required value="100" class="w-full rounded-xl border-slate-200 bg-slate-50/50">
                    </div>

                    <!-- CSV File -->
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">CSV File</label>
                        <input type="file" name="csv_file" accept=".csv" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-50">
                    <button type="submit" class="premium-button bg-emerald-500 text-white hover:bg-emerald-600 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                        Process Import
                    </button>
                </div>
            </form>
        </div>

        <!-- Manual Form -->
        <div id="manual-section" class="bg-white rounded-2xl border border-slate-100 shadow-xl p-8">
            <form action="{{ route('teacher.grades.bulk-store') }}" method="POST" id="bulkGradeForm" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 pb-6 border-b border-slate-50">
                    <!-- Subject Selection -->
                    <div>
                        <label for="subject_id" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Subject <span class="text-rose-500">*</span>
                        </label>
                        <select id="subject_id" name="subject_id" required onchange="this.form.action='{{ route('teacher.grades.bulk-create') }}'; this.form.method='GET'; this.form.submit();"
                                class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50 @error('subject_id') border-rose-500 @enderror">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }} ({{ $subject->code }})
                                </option>
                            @endforeach
                        </select>
                        @error('subject_id')
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
                                <option value="{{ $period }}" {{ old('grading_period') == $period ? 'selected' : '' }}>{{ $period }} Period</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date_given" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Date <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" id="date_given" name="date_given" required
                               value="{{ old('date_given', date('Y-m-d')) }}"
                               class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pb-6 border-b border-slate-50">
                    <!-- Title -->
                    <div class="md:col-span-1">
                        <label for="title" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Record Title <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="title" name="title" required
                               value="{{ old('title') }}"
                               class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50"
                               placeholder="e.g. Unit Quiz 1">
                    </div>

                    <!-- Grade Type -->
                    <div>
                        <label for="type" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Type <span class="text-rose-500">*</span>
                        </label>
                        <select id="type" name="type" required
                                class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50">
                            @foreach(App\Models\Grade::getTypes() as $type)
                                <option value="{{ $type }}" {{ old('type') == $type ? 'selected' : '' }}>{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Total Score -->
                    <div>
                        <label for="total_score" class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">
                            Points Possible <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" id="total_score" name="total_score" required
                               value="{{ old('total_score', 100) }}"
                               class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50">
                    </div>
                </div>

                <!-- Students Table -->
                <div class="space-y-4">
                    <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Enter Scores</h3>
                    <div class="overflow-hidden border border-slate-100 rounded-2xl">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50/50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Student</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest w-40">Score</th>
                                    <th class="px-6 py-4 text-left text-[10px] font-black text-slate-400 uppercase tracking-widest">Remarks</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($students as $student)
                                    <tr class="hover:bg-slate-50/30">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="text-xs font-bold text-slate-800">{{ $student->user->name ?? 'N/A' }}</span>
                                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $student->student_id }}</span>
                                            </div>
                                            <input type="hidden" name="students[{{ $student->id }}][student_id]" value="{{ $student->id }}">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="number" 
                                                   name="students[{{ $student->id }}][score]" 
                                                   step="0.01"
                                                   class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50"
                                                   placeholder="0.00">
                                        </td>
                                        <td class="px-6 py-4">
                                            <input type="text" 
                                                   name="students[{{ $student->id }}][remarks]" 
                                                   class="w-full rounded-xl border-slate-200 focus:border-sky-500 focus:ring-sky-500 bg-slate-50/50"
                                                   placeholder="Optional remarks">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($students->isEmpty())
                    <div class="p-6 text-center bg-rose-50 border border-rose-100 rounded-2xl">
                        <p class="text-sm font-bold text-rose-600">No students found. Please ensure students are enrolled in your subjects.</p>
                    </div>
                @endif

                <!-- Submit Buttons -->
                <div class="flex justify-end gap-3 pt-6">
                    <a href="{{ route('teacher.grades.index') }}" 
                       class="premium-button bg-slate-100 text-slate-600 hover:bg-slate-200">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="premium-button-primary shadow-sky-100"
                            {{ $students->isEmpty() ? 'disabled' : '' }}>
                        Save All Grades
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function toggleMethod(method) {
            const manualSec = document.getElementById('manual-section');
            const importSec = document.getElementById('import-section');
            const btnManual = document.getElementById('btn-manual');
            const btnImport = document.getElementById('btn-import');

            if (method === 'manual') {
                manualSec.classList.remove('hidden');
                importSec.classList.add('hidden');
                btnManual.className = 'px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all bg-white text-sky-600 shadow-sm';
                btnImport.className = 'px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-slate-500 hover:text-slate-700';
            } else {
                manualSec.classList.add('hidden');
                importSec.classList.remove('hidden');
                btnImport.className = 'px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all bg-white text-sky-600 shadow-sm';
                btnManual.className = 'px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all text-slate-500 hover:text-slate-700';
            }
        }
    </script>
</x-app-layout>
