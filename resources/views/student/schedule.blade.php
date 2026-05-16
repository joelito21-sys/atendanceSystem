@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-violet-50 via-white to-purple-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">My Class Schedule</h1>
            <p class="mt-2 text-gray-600">View your weekly class schedule</p>
        </div>

        <!-- Weekly Schedule Grid -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="grid grid-cols-6 gap-px bg-gray-200">
                <!-- Time Column Header -->
                <div class="bg-gray-50 px-4 py-3">
                    <p class="text-sm font-semibold text-gray-700">Time</p>
                </div>
                
                <!-- Day Headers -->
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                    <div class="bg-gray-50 px-4 py-3 text-center">
                        <p class="text-sm font-semibold text-gray-700">{{ $day }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Schedule Grid -->
            @php
                $timeSlots = [];
                foreach($schedules as $schedule) {
                    $time = substr($schedule->start_time, 0, 5) . ' - ' . substr($schedule->end_time, 0, 5);
                    if (!in_array($time, $timeSlots)) {
                        $timeSlots[] = $time;
                    }
                }
                sort($timeSlots);
            @endphp

            @forelse($timeSlots as $timeSlot)
                <div class="grid grid-cols-6 gap-px bg-gray-200">
                    <!-- Time Column -->
                    <div class="bg-white px-4 py-6">
                        <p class="text-sm font-medium text-gray-900">{{ $timeSlot }}</p>
                    </div>

                    <!-- Day Columns -->
                    @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                        @php
                            $daySchedule = $schedules->first(function($s) use ($day, $timeSlot) {
                                $scheduleTime = substr($s->start_time, 0, 5) . ' - ' . substr($s->end_time, 0, 5);
                                return $s->day_of_week === $day && $scheduleTime === $timeSlot;
                            });
                        @endphp

                        <div class="bg-white px-4 py-6 min-h-[100px]">
                            @if($daySchedule)
                                <div class="bg-gradient-to-br from-violet-100 to-purple-100 rounded-lg p-3 border-l-4 border-violet-600">
                                    <p class="font-semibold text-gray-900 text-sm mb-1">
                                        {{ $daySchedule->subject->name ?? 'N/A' }}
                                    </p>
                                    <p class="text-xs text-gray-600 mb-1">
                                        {{ $daySchedule->subject->code ?? '' }}
                                    </p>
                                    @if($daySchedule->room)
                                        <p class="text-xs text-violet-700 font-medium">
                                            📍 {{ $daySchedule->room }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @empty
                <div class="bg-white px-6 py-12 text-center">
                    <p class="text-gray-500">No classes scheduled yet.</p>
                </div>
            @endforelse
        </div>

        <!-- Schedule List View (Mobile Friendly) -->
        <div class="mt-8 lg:hidden">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Schedule List</h2>
            <div class="space-y-4">
                @forelse($schedules->groupBy('day_of_week') as $day => $daySchedules)
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <h3 class="text-lg font-bold text-violet-600 mb-4">{{ $day }}</h3>
                        <div class="space-y-3">
                            @foreach($daySchedules as $schedule)
                                <div class="border-l-4 border-violet-600 pl-4 py-2">
                                    <p class="font-semibold text-gray-900">{{ $schedule->subject->name ?? 'N/A' }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - 
                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                    </p>
                                    @if($schedule->room)
                                        <p class="text-sm text-violet-700">📍 {{ $schedule->room }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No classes scheduled.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
