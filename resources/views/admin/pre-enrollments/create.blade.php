<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-2">
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">
                Add to <span class="text-gradient">Master Enrollment</span> List
            </h2>
            <p class="text-slate-500">Create automated enrollment rules for new students</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.pre-enrollments.store') }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="glass-card shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-sky-500 to-indigo-500"></div>
                
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

                    {{-- Student Identification Section --}}
                    <section class="space-y-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-sky-100 text-sky-600 text-xs font-bold">1</span>
                            <h3 class="text-lg font-bold text-slate-800">Student & Guardian Details</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Student ID Number</label>
                                <x-text-input name="student_id_number" value="{{ old('student_id_number') }}" required placeholder="e.g. STU-2026-001" class="w-full" />
                                <x-input-error :messages="$errors->get('student_id_number')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Full Name</label>
                                <x-text-input name="student_name" value="{{ old('student_name') }}" required placeholder="e.g. John Doe" class="w-full" />
                                <x-input-error :messages="$errors->get('student_name')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Student Email</label>
                                <x-text-input name="student_email" type="email" value="{{ old('student_email') }}" required placeholder="e.g. j.doe@email.com" class="w-full" />
                                <x-input-error :messages="$errors->get('student_email')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Parent/Guardian Email</label>
                                <x-text-input name="parent_email" type="email" value="{{ old('parent_email') }}" required placeholder="e.g. guardian@email.com" class="w-full" />
                                <x-input-error :messages="$errors->get('parent_email')" class="mt-2" />
                            </div>
                        </div>
                        <p class="text-xs text-slate-400 mt-2 italic">Invitation emails with login credentials will be sent to both emails automatically.</p>
                    </section>

                    <hr class="border-slate-100">

                    {{-- Curriculum Mapping Section --}}
                    <section class="space-y-6">
                        <div class="flex items-center gap-2 mb-4">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-sky-100 text-sky-600 text-xs font-bold">2</span>
                            <h3 class="text-lg font-bold text-slate-800">Curriculum & Subjects</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Course/Program</label>
                                <x-text-input id="course_filter" list="courses_list" placeholder="Start typing course..." class="w-full" />
                                <datalist id="courses_list">
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->code }})</option>
                                    @endforeach
                                </datalist>
                                <input type="hidden" name="course_id" id="course_id_hidden">
                                <x-input-error :messages="$errors->get('course_id')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Year Level</label>
                                <x-text-input id="year_filter" name="year_level" value="{{ old('year_level') }}" list="years_list" placeholder="e.g. 1st Year" class="w-full" />
                                <datalist id="years_list">
                                    <option value="1st Year">
                                    <option value="2nd Year">
                                    <option value="3rd Year">
                                    <option value="4th Year">
                                </datalist>
                                <x-input-error :messages="$errors->get('year_level')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Semester</label>
                                <x-text-input id="semester_filter" name="semester" list="semesters_list" required placeholder="e.g. 1st Semester" class="w-full" />
                                <datalist id="semesters_list">
                                    <option value="1st Semester">
                                    <option value="2nd Semester">
                                    <option value="Summer">
                                </datalist>
                                <x-input-error :messages="$errors->get('semester')" class="mt-2" />
                            </div>
                        </div>

                        <div class="p-6 rounded-2xl bg-slate-50/50 border border-slate-100 border-dashed">
                            <label class="block text-sm font-bold text-slate-700 mb-4 text-center">Select Subjects to Include</label>
                            <div id="subjects_container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 min-h-[120px] items-center justify-center text-center">
                                <p class="text-slate-400 text-sm italic col-span-full">Select curriculum above to fetch subjects.</p>
                            </div>
                            @error('subject_codes')
                                <p class="mt-4 text-sm text-rose-500 text-center font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </section>

                    <hr class="border-slate-100">

                    {{-- Deployment details --}}
                    <section class="space-y-4 text-left">
                         <div class="flex items-center gap-2 mb-4">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-sky-100 text-sky-600 text-xs font-bold">3</span>
                            <h3 class="text-lg font-bold text-slate-800">Deployment Details</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Section</label>
                                <x-text-input name="section" required list="sections_list" placeholder="e.g. Einstein" class="w-full" />
                                <datalist id="sections_list">
                                    <option value="A">
                                    <option value="B">
                                    <option value="Einstein">
                                    <option value="Newton">
                                </datalist>
                                <x-input-error :messages="$errors->get('section')" class="mt-2" />
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">School Year</label>
                                <x-text-input name="school_year" value="{{ old('school_year', date('Y') . '-' . (date('Y') + 1)) }}" required class="w-full" />
                                <x-input-error :messages="$errors->get('school_year')" class="mt-2" />
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Footer / Actions --}}
                <div class="bg-slate-50/80 p-6 flex flex-col sm:flex-row justify-end items-center gap-4">
                    <a href="{{ route('admin.pre-enrollments.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 px-4 py-2">
                        Discard Changes
                    </a>
                    <button type="submit" class="premium-button-primary w-full sm:w-auto px-12">
                        Create Enrollment Rule
                    </button>
                </div>
            </div>
        </form>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const courseFilter = document.getElementById('course_filter');
            const yearFilter = document.getElementById('year_filter');
            const semesterFilter = document.getElementById('semester_filter');
            const container = document.getElementById('subjects_container');

            function fetchSubjects() {
                const courseValue = courseFilter.value;
                const yearLevel = yearFilter.value;
                const semester = semesterFilter.value;

                // Find the ID from the datalist
                const options = document.getElementById('courses_list').options;
                let courseId = '';
                for (let i = 0; i < options.length; i++) {
                    if (options[i].innerText === courseValue || options[i].value === courseValue) {
                        // If it's the ID itself or the name
                        courseId = options[i].value;
                        break;
                    }
                }

                if (!courseId || !yearLevel || !semester) {
                    container.innerHTML = '<p class="text-slate-400 text-sm italic col-span-full">Select curriculum above to fetch subjects.</p>';
                    return;
                }

                container.innerHTML = '<div class="col-span-full py-4 text-center"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div></div>';

                fetch(`{{ route('admin.pre-enrollments.get-subjects') }}?course_id=${courseId}&year_level=${yearLevel}&semester=${semester}`)
                    .then(response => response.json())
                    .then(subjects => {
                        if (subjects.length === 0) {
                            container.innerHTML = '<p class="text-slate-400 text-sm col-span-full italic">No subjects found for this selection.</p>';
                            return;
                        }

                        let html = '';
                        subjects.forEach(subject => {
                            html += `
                                <label class="flex items-center space-x-3 p-3 hover:bg-white rounded-xl transition-all cursor-pointer border border-slate-100 shadow-sm hover:shadow-md hover:border-sky-200">
                                    <input type="checkbox" name="subject_codes[]" value="${subject.code}" checked class="rounded-lg text-indigo-600 focus:ring-sky-500 border-slate-300">
                                    <span class="text-sm font-medium text-slate-700">
                                        ${subject.name} <br> <span class="text-xs text-slate-400 font-normal">${subject.code}</span>
                                    </span>
                                </label>
                            `;
                        });
                        container.innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        container.innerHTML = '<p class="text-rose-500 text-sm col-span-full font-medium">Error loading subjects. Please try again.</p>';
                    });
            }

            [courseFilter, yearFilter, semesterFilter].forEach(el => {
                el.addEventListener('input', fetchSubjects);
            });
        });
    </script>
</x-app-layout>
