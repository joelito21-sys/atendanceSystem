<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Student Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.students.edit', $student) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">Edit</a>
                <a href="{{ route('admin.students.qr-code', $student) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">QR Code</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Profile Card -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-xl p-6 lg:p-8 text-white mb-8">
                <div class="flex items-center space-x-6">
                    <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-3xl font-bold">{{ substr($student->user->name ?? 'S', 0, 1) }}</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $student->user->name ?? 'Unknown' }}</h1>
                        <p class="text-indigo-100">{{ $student->grade_level }} - {{ $student->section }}</p>
                        <p class="text-indigo-200 text-sm mt-1">ID: {{ $student->student_id_number }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Student Info -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Student Information</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Email</dt>
                            <dd class="text-gray-800">{{ $student->user->email ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Phone</dt>
                            <dd class="text-gray-800">{{ $student->phone ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Birth Date</dt>
                            <dd class="text-gray-800">{{ $student->birth_date?->format('M d, Y') ?? 'N/A' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Address</dt>
                            <dd class="text-gray-800">{{ $student->address ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Parent Info -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Parent/Guardian</h3>
                    @if($student->parent)
                        <dl class="space-y-3">
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Name</dt>
                                <dd class="text-gray-800">{{ $student->parent->user->name ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Email</dt>
                                <dd class="text-gray-800">{{ $student->parent->notification_email }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Phone</dt>
                                <dd class="text-gray-800">{{ $student->parent->phone_number ?? 'N/A' }}</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-500">Relationship</dt>
                                <dd class="text-gray-800">{{ $student->parent->relationship }}</dd>
                            </div>
                        </dl>
                    @else
                        <p class="text-gray-500">No parent linked</p>
                    @endif
                </div>

                <!-- Enrolled Subjects -->
                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Enrolled Subjects</h3>
                    @if($student->subjects->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            @foreach($student->subjects as $subject)
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="font-medium text-gray-800">{{ $subject->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $subject->code }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No subjects enrolled</p>
                    @endif
                </div>

                <!-- Academic Performance -->
                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Academic Performance (Current Weighted)</h3>
                    @if($student->subjects->count() > 0)
                        <div class="space-y-4">
                            @foreach($student->subjects as $subject)
                                @if(isset($weightedGrades[$subject->id]))
                                    @php $summary = $weightedGrades[$subject->id]; @endphp
                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <div class="flex justify-between items-start mb-3">
                                            <div>
                                                <p class="font-bold text-gray-800">{{ $subject->name }}</p>
                                                <p class="text-xs text-gray-400 uppercase font-black">{{ $subject->code }}</p>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-xl font-black text-indigo-600">{{ $summary['final'] }}%</span>
                                                <p class="text-[10px] text-gray-400 uppercase font-black">Partial Grade</p>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-3 border-t border-gray-200/50">
                                            <div>
                                                <p class="text-[9px] font-black text-gray-400 uppercase">Attendance (20%)</p>
                                                <p class="text-xs font-bold text-gray-700">{{ $summary['attendance'] }}%</p>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-black text-gray-400 uppercase">Oral (20%)</p>
                                                <p class="text-xs font-bold text-gray-700">{{ $summary['oral'] }}%</p>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-black text-gray-400 uppercase">Quizzes (30%)</p>
                                                <p class="text-xs font-bold text-gray-700">{{ $summary['quiz'] }}%</p>
                                            </div>
                                            <div>
                                                <p class="text-[9px] font-black text-gray-400 uppercase">Exams (30%)</p>
                                                <p class="text-xs font-bold text-gray-700">{{ $summary['exam'] }}%</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No subjects enrolled</p>
                    @endif
                </div>

                <!-- Attendance Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-2 border-b">Attendance Summary</h3>
                    <div class="grid grid-cols-4 gap-4 text-center">
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-2xl font-bold text-green-600">{{ $student->attendanceRecords->where('status', 'present')->count() }}</p>
                            <p class="text-sm text-gray-500">Present</p>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <p class="text-2xl font-bold text-yellow-600">{{ $student->attendanceRecords->where('status', 'late')->count() }}</p>
                            <p class="text-sm text-gray-500">Late</p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4">
                            <p class="text-2xl font-bold text-red-600">{{ $student->attendanceRecords->where('status', 'absent')->count() }}</p>
                            <p class="text-sm text-gray-500">Absent</p>
                        </div>
                        <div class="bg-indigo-50 rounded-lg p-4">
                            <p class="text-2xl font-bold text-indigo-600">{{ $student->grades->count() }}</p>
                            <p class="text-sm text-gray-500">Records</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('admin.students.index') }}" class="text-indigo-600 hover:text-indigo-800">← Back to Students</a>
            </div>
        </div>
    </div>
</x-app-layout>
