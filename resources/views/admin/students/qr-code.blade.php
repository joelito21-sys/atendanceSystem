<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Student QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden p-8 text-center">
                <h1 class="text-2xl font-bold text-gray-800">{{ $student->user->name }}</h1>
                <p class="text-gray-500">{{ $student->grade_level }} - {{ $student->section }}</p>
                <p class="text-indigo-600 font-medium mt-1">ID: {{ $student->student_id_number }}</p>

                <div class="mt-8 bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8">
                    <div class="bg-white rounded-xl p-4 inline-block shadow-lg">
                        <img src="{{ $qrCode->getDataUri() }}" alt="QR Code" class="w-64 h-64 mx-auto">
                    </div>
                </div>

                <p class="mt-4 text-sm text-gray-500">Code: <span class="font-mono">{{ $qrCode->code }}</span></p>

                <div class="mt-8 flex justify-center space-x-4">
                    <button onclick="window.print()" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                        Print QR Code
                    </button>
                    <a href="{{ route('admin.students.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
