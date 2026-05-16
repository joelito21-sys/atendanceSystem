<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Notification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #4f46e5;
            margin: 0;
            font-size: 24px;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 14px;
            margin: 10px 0;
        }
        .status-time_in {
            background: #dcfce7;
            color: #166534;
        }
        .status-time_out {
            background: #fef3c7;
            color: #92400e;
        }
        .status-late {
            background: #fee2e2;
            color: #991b1b;
        }
        .status-absent {
            background: #fecaca;
            color: #7f1d1d;
        }
        .details {
            background: #f8fafc;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .details p {
            margin: 8px 0;
        }
        .details strong {
            color: #4f46e5;
        }
        .footer {
            text-align: center;
            color: #666;
            font-size: 12px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .time {
            font-size: 28px;
            font-weight: bold;
            color: #4f46e5;
            text-align: center;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Attendance Notification</h1>
        </div>
        
        <p>Dear Parent/Guardian,</p>
        
        <p>This is to inform you about your child's attendance status:</p>
        
        <div style="text-align: center;">
            <span class="status-badge status-{{ $type }}">
                @switch($type)
                    @case('time_in')
                        ✅ Arrived at School
                        @break
                    @case('time_out')
                        👋 Left School
                        @break
                    @case('late')
                        ⚠️ Arrived Late
                        @break
                    @case('absent')
                        ❌ Marked Absent
                        @break
                @endswitch
            </span>
        </div>
        
        <div class="time">
            {{ $timestamp->format('h:i A') }}
        </div>
        
        <div class="details">
            <p><strong>Student:</strong> {{ $student->user->name }}</p>
            <p><strong>Student ID:</strong> {{ $student->student_id_number }}</p>
            <p><strong>Grade & Section:</strong> {{ $student->grade_level }} - {{ $student->section }}</p>
            @if($subject)
            <p><strong>Subject:</strong> {{ $subject->name }}</p>
            @endif
            <p><strong>Date:</strong> {{ $timestamp->format('F j, Y') }}</p>
            <p><strong>Time:</strong> {{ $timestamp->format('h:i A') }}</p>
        </div>
        
        <p>If you have any questions or concerns, please contact the school administration.</p>
        
        <div class="footer">
            <p>This is an automated message from the Student Attendance System.</p>
            <p>Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
