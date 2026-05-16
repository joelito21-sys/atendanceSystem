<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Student Transcript</title>
    <style>
        body { font-family: sans-serif; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .school-name { font-size: 24px; font-weight: bold; margin: 0; }
        .document-title { font-size: 18px; margin: 10px 0; }
        
        .student-info { margin-bottom: 30px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding: 5px; }
        .label { font-weight: bold; width: 120px; }
        
        .grades-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
        .grades-table th, .grades-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .grades-table th { background-color: #f8f9fa; }
        
        .subject-header { background-color: #e9ecef; font-weight: bold; }
        .summary { margin-top: 30px; text-align: right; }
        .gpa { font-size: 16px; font-weight: bold; }
        
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="school-name">School Attendance System</h1>
        <p class="document-title">Official Student Transcript</p>
    </div>

    <div class="student-info">
        <table class="info-table">
            <tr>
                <td class="label">Student Name:</td>
                <td>{{ $student->user->name }}</td>
                <td class="label">Student ID:</td>
                <td>{{ $student->student_id }}</td>
            </tr>
            <tr>
                <td class="label">Course:</td>
                <td>{{ $student->course->name ?? 'N/A' }}</td>
                <td class="label">Generated:</td>
                <td>{{ now()->format('M d, Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="grades-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Date</th>
                <th>Remarks</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gradesBySubject as $subjectId => $data)
                <tr class="subject-header">
                    <td colspan="3">
                        {{ $data['subject']->name }} ({{ $data['subject']->code }})
                    </td>
                    <td>Avg: {{ number_format($data['average'], 2) }}</td>
                </tr>
                @foreach($data['grades'] as $grade)
                    <tr>
                        <td>{{ ucfirst($grade->grade_type) }}</td>
                        <td>{{ $grade->created_at->format('M d, Y') }}</td>
                        <td>{{ $grade->remarks ?? '-' }}</td>
                        <td>{{ number_format($grade->grade, 2) }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <p class="gpa">Overall Average Grade: {{ number_format($overallAverage, 2) }}</p>
    </div>

    <div class="footer">
        <p>This is a computer-generated document. No signature is required.</p>
    </div>
</body>
</html>
