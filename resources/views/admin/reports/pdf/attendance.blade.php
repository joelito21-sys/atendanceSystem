<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Attendance Report</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .stats { margin-bottom: 20px; }
        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .stats-table td { padding: 8px; border: 1px solid #ddd; text-align: center; }
        .stats-label { font-weight: bold; background-color: #f8f9fa; }
        table { width: 100%; border-collapse: collapse; font-size: 12px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; font-weight: bold; }
        .present { color: green; }
        .absent { color: red; }
        .late { color: #d39e00; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Attendance Report</h2>
        <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <div class="stats">
        <table class="stats-table">
            <tr>
                <td class="stats-label">Total Records</td>
                <td class="stats-label">Present</td>
                <td class="stats-label">Absent</td>
                <td class="stats-label">Late</td>
            </tr>
            <tr>
                <td>{{ $stats['total'] }}</td>
                <td style="color: green">{{ $stats['present'] }}</td>
                <td style="color: red">{{ $stats['absent'] }}</td>
                <td style="color: #d39e00">{{ $stats['late'] }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Student</th>
                <th>Subject</th>
                <th>Time In</th>
                <th>Time Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}</td>
                    <td>{{ $record->student->user->name ?? 'N/A' }}</td>
                    <td>{{ $record->subject->name ?? 'N/A' }}</td>
                    <td>{{ $record->time_in ? \Carbon\Carbon::parse($record->time_in)->format('h:i A') : '-' }}</td>
                    <td>{{ $record->time_out ? \Carbon\Carbon::parse($record->time_out)->format('h:i A') : '-' }}</td>
                    <td>
                        <span class="{{ $record->status }}">
                            {{ ucfirst($record->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
