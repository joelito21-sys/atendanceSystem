<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('QR Scanner - Attendance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl">
                <div class="p-6 lg:p-8">
                    <!-- Subject Selection -->
                    <div class="mb-6">
                        <label for="subject_id" class="block text-sm font-medium text-gray-700 mb-2">Select Subject (Optional for Auto-Detect)</label>
                        <select id="subject_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Auto-Detect Subject --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }} ({{ $subject->code }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Auto-Detect Mode Toggle -->
                    <div class="mb-6 flex items-center justify-between bg-blue-50 p-4 rounded-lg">
                        <div>
                            <h4 class="font-medium text-blue-900">Auto-Detect Mode</h4>
                            <p class="text-sm text-blue-700">Automatically detect Time In/Out & Subject</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="auto-detect-toggle" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <!-- Scan Mode Toggle (Manual) -->
                    <div id="manual-controls" class="hidden flex space-x-4 mb-6">
                        <button type="button" id="btn-time-in" class="flex-1 py-3 px-4 bg-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-400 transition-colors">
                            ✓ Time In
                        </button>
                        <button type="button" id="btn-time-out" class="flex-1 py-3 px-4 bg-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-400 transition-colors">
                            ← Time Out
                        </button>
                    </div>

                    <!-- Scanner Area -->
                    <div class="bg-gray-100 rounded-xl p-4 mb-6">
                        <div id="reader" class="w-full max-w-md mx-auto"></div>
                        <p class="text-center text-gray-500 mt-4">Point the camera at a student's QR code</p>
                    </div>

                    <!-- Manual Entry -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Manual QR Code Entry</h3>
                        <div class="flex space-x-4">
                            <input type="text" id="manual-qr" placeholder="Enter QR Code" class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <button type="button" id="btn-manual-scan" class="px-6 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                                Submit
                            </button>
                        </div>
                    </div>

                    <!-- Result Display -->
                    <div id="scan-result" class="mt-6 hidden">
                        <div id="result-content" class="p-4 rounded-lg"></div>
                    </div>

                    <!-- Recent Scans -->
                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-800 mb-4">Recent Scans</h3>
                        <div id="recent-scans" class="space-y-2">
                            <p class="text-gray-500 text-sm">No scans yet</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Scanner Script -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let scanMode = 'auto'; // auto, time-in, time-out
        let html5QrCode = null;
        const recentScans = [];
        let isProcessing = false;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize scanner
            initScanner();

            // Auto-Detect Toggle
            const autoToggle = document.getElementById('auto-detect-toggle');
            const manualControls = document.getElementById('manual-controls');
            
            autoToggle.addEventListener('change', function() {
                if (this.checked) {
                    scanMode = 'auto';
                    manualControls.classList.add('hidden');
                } else {
                    scanMode = 'time-in'; // Default to time-in when disabled
                    manualControls.classList.remove('hidden');
                    updateManualButtons();
                }
            });

            // Mode toggle buttons
            document.getElementById('btn-time-in').addEventListener('click', function() {
                scanMode = 'time-in';
                updateManualButtons();
            });

            document.getElementById('btn-time-out').addEventListener('click', function() {
                scanMode = 'time-out';
                updateManualButtons();
            });

            function updateManualButtons() {
                const btnIn = document.getElementById('btn-time-in');
                const btnOut = document.getElementById('btn-time-out');
                
                if (scanMode === 'time-in') {
                    btnIn.className = 'flex-1 py-3 px-4 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition-colors';
                    btnOut.className = 'flex-1 py-3 px-4 bg-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-400 transition-colors';
                } else {
                    btnIn.className = 'flex-1 py-3 px-4 bg-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-400 transition-colors';
                    btnOut.className = 'flex-1 py-3 px-4 bg-orange-600 text-white rounded-lg font-medium hover:bg-orange-700 transition-colors';
                }
            }

            // Manual scan
            document.getElementById('btn-manual-scan').addEventListener('click', function() {
                const code = document.getElementById('manual-qr').value.trim();
                if (code) {
                    processQrCode(code);
                }
            });
        });

        function initScanner() {
            html5QrCode = new Html5Qrcode("reader");
            html5QrCode.start(
                { facingMode: "environment" },
                {
                    fps: 10,
                    qrbox: { width: 250, height: 250 }
                },
                onScanSuccess,
                onScanFailure
            ).catch(err => {
                console.log("Camera not available:", err);
                document.getElementById('reader').innerHTML = '<p class="text-center text-gray-500 py-8">Camera not available. Please use manual entry.</p>';
            });
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) return;
            processQrCode(decodedText);
        }

        function onScanFailure(error) {
            // Ignore scan failures
        }

        function processQrCode(code) {
            isProcessing = true;
            const subjectId = document.getElementById('subject_id').value;
            
            // Validation for Manual Mode
            if (scanMode !== 'auto' && !subjectId) {
                showResult(false, 'Please select a subject first (or enable Auto-Detect).');
                isProcessing = false;
                return;
            }

            let url = '';
            if (scanMode === 'auto') {
                url = '{{ route("api.attendance.process") }}';
            } else {
                 url = scanMode === 'time-in' 
                    ? '{{ route("teacher.attendance.time-in") }}'
                    : '{{ route("teacher.attendance.time-out") }}';
            }

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    qr_code: code,
                    subject_id: subjectId
                })
            })
            .then(response => response.json().then(data => ({ status: response.status, body: data })))
            .then(({ status, body }) => {
                const success = status >= 200 && status < 300; // Check HTTP status
                showResult(success, body.message, body);
                
                if (success) {
                    addRecentScan(body);
                    // Clear manual input if success
                    document.getElementById('manual-qr').value = '';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showResult(false, 'An unexpected error occurred. Please check console.');
            })
            .finally(() => {
                // Add a small delay before allowing next scan to prevent double scans
                setTimeout(() => {
                    isProcessing = false;
                }, 2000);
            });
        }


        function showResult(success, message, data = {}) {
            const resultDiv = document.getElementById('scan-result');
            const contentDiv = document.getElementById('result-content');
            
            resultDiv.classList.remove('hidden');
            contentDiv.className = 'p-4 rounded-lg ' + (success ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800');
            
            let html = `<p class="font-medium">${message}</p>`;
            if (data.student_name) {
                html += `<p class="text-sm mt-1">Student: ${data.student_name} (${data.student_id || ''})</p>`;
            }
            if (data.time_in) {
                html += `<p class="text-sm">Time In: ${data.time_in}</p>`;
            }
            if (data.time_out) {
                html += `<p class="text-sm">Time Out: ${data.time_out}</p>`;
            }
            
            contentDiv.innerHTML = html;

            // Auto-hide after 5 seconds
            setTimeout(() => {
                resultDiv.classList.add('hidden');
            }, 5000);
        }

        function addRecentScan(data) {
            recentScans.unshift({
                name: data.student_name,
                time: new Date().toLocaleTimeString(),
                type: scanMode,
                status: data.status
            });

            if (recentScans.length > 10) {
                recentScans.pop();
            }

            updateRecentScansUI();
        }

        function updateRecentScansUI() {
            const container = document.getElementById('recent-scans');
            
            if (recentScans.length === 0) {
                container.innerHTML = '<p class="text-gray-500 text-sm">No scans yet</p>';
                return;
            }

            container.innerHTML = recentScans.map(scan => `
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <span class="w-2 h-2 rounded-full ${scan.type === 'time-in' ? 'bg-green-500' : 'bg-orange-500'}"></span>
                        <span class="font-medium text-gray-800">${scan.name}</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        ${scan.type === 'time-in' ? 'IN' : 'OUT'} at ${scan.time}
                    </div>
                </div>
            `).join('');
        }
    </script>
</x-app-layout>
