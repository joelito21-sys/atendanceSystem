<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Subject') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <form action="{{ route('admin.subjects.update', $subject) }}" method="POST" class="p-6 lg:p-8">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $subject->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="code" :value="__('Code')" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full" :value="old('code', $subject->code)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('code')" />
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="course_id" :value="__('Course')" />
                            <select id="course_id" name="course_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Select Course --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id', $subject->course_id) == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }} ({{ $course->code }})
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('course_id')" />
                        </div>

                        <div>
                            <x-input-label for="year_level" :value="__('Year Level')" />
                            <select id="year_level" name="year_level" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Select Year --</option>
                                <option value="1st Year" {{ old('year_level', $subject->year_level) == '1st Year' ? 'selected' : '' }}>1st Year</option>
                                <option value="2nd Year" {{ old('year_level', $subject->year_level) == '2nd Year' ? 'selected' : '' }}>2nd Year</option>
                                <option value="3rd Year" {{ old('year_level', $subject->year_level) == '3rd Year' ? 'selected' : '' }}>3rd Year</option>
                                <option value="4th Year" {{ old('year_level', $subject->year_level) == '4th Year' ? 'selected' : '' }}>4th Year</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('year_level')" />
                        </div>

                        <div>
                            <x-input-label for="semester" :value="__('Semester')" />
                            <select id="semester" name="semester" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Select Semester --</option>
                                <option value="1st Semester" {{ old('semester', $subject->semester) == '1st Semester' ? 'selected' : '' }}>1st Semester</option>
                                <option value="2nd Semester" {{ old('semester', $subject->semester) == '2nd Semester' ? 'selected' : '' }}>2nd Semester</option>
                                <option value="Full Year" {{ old('semester', $subject->semester) == 'Full Year' ? 'selected' : '' }}>Full Year</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('semester')" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Assign Teacher</label>
                            <select name="teacher_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Select Teacher --</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ old('teacher_id', $subject->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->user->name ?? 'Unknown' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Grade Level</label>
                            <input type="text" name="grade_level" value="{{ old('grade_level', $subject->grade_level) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Units *</label>
                            <input type="number" name="units" value="{{ old('units', $subject->units) }}" required min="1" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="is_active" id="is_active" {{ $subject->is_active ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $subject->description) }}</textarea>
                        </div>

                        <!-- Enroll Students Section -->
                        <div class="md:col-span-2 mt-4">
                            <h3 class="text-lg font-medium text-gray-800 mb-4 pb-2 border-b">Enrolled Students</h3>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 max-h-48 overflow-y-auto">
                                @foreach($students as $student)
                                    <label class="flex items-center p-2 bg-gray-50 rounded hover:bg-gray-100 cursor-pointer">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" {{ in_array($student->id, $enrolledStudentIds) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">{{ $student->user->name ?? 'Unknown' }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('admin.subjects.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Update Subject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
