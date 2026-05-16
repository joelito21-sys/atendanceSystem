<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Grade Report</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h2>Grade Report</h2>
        <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
    </div>

    <div class="stats">
        <table class="stats-table">
            <tr>
                <td class="stats-label">Total Grades</td>
                <td class="stats-label">Average</td>
                <td class="stats-label">Highest</td>
                <td class="stats-label">Lowest</td>
            </tr>
            <tr>
                <td>{{ $stats['total'] }}</td>
                <td>{{ number_format($stats['average'], 2) }}</td>
                <td style="color: green">{{ number_format($stats['highest'], 2) }}</td>
                <td style="color: red">{{ number_format($stats['lowest'], 2) }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Student</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Grade</th>
                <th>Teacher</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->created_at->format('M d, Y') }}</td>
                    <td>{{ $grade->student->user->name ?? 'N/A' }}</td>
                    <td>{{ $grade->subject->name ?? 'N/A' }}</td>
                    <td>{{ ucfirst($grade->grade_type) }}</td>
                    <td>{{ number_format($grade->grade, 2) }}</td>
                    <td>{{ $grade->teacher->user->name ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
