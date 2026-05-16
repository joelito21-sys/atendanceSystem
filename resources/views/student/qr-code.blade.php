<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My QR Code') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                <div class="p-6 lg:p-8 text-center">
                    @if(!$qrCode)
                        <div class="py-12">
                            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-800">No QR Code Available</h3>
                            <p class="text-gray-500 mt-2">Please contact your administrator to generate a QR code.</p>
                        </div>
                    @else
                        <!-- Student Info -->
                        <div class="mb-6">
                            <h1 class="text-2xl font-bold text-gray-800">{{ $student->user->name }}</h1>
                            <p class="text-gray-500">{{ $student->grade_level }} - {{ $student->section }}</p>
                            <p class="text-indigo-600 font-medium">ID: {{ $student->student_id_number }}</p>
                        </div>

                        <!-- QR Code Display -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-2xl p-8 mb-6">
                            <div class="bg-white rounded-xl p-4 inline-block shadow-lg">
                                <img src="{{ $qrCode->getDataUri() }}" alt="My QR Code" class="w-64 h-64 mx-auto">
                            </div>
                        </div>

                        <!-- QR Code Info -->
                        <div class="text-sm text-gray-500 mb-6">
                            <p>Code: <span class="font-mono text-gray-700">{{ $qrCode->code }}</span></p>
                            <p class="mt-1">Generated: {{ $qrCode->generated_at->format('M d, Y h:i A') }}</p>
                        </div>

                        <!-- Instructions -->
                        <div class="bg-blue-50 rounded-xl p-4 text-left">
                            <h4 class="font-medium text-blue-800 mb-2">How to Use</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Show this QR code to your teacher when entering class</li>
                                <li>• The teacher will scan it to record your attendance</li>
                                <li>• Your parent will receive an email notification</li>
                                <li>• Show again when leaving class for time-out</li>
                            </ul>
                        </div>

                        <!-- Download/Print Button -->
                        <div class="mt-6">
                            <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                                Print QR Code
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .bg-gradient-to-br, .bg-gradient-to-br * {
                visibility: visible;
            }
            .bg-gradient-to-br {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
            }
        }
    </style>
</x-app-layout>
