<!DOCTYPE html>
<html>
<head>
    <title>Enrollment Confirmed</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 8px;">
        <h2 style="color: #4f46e5;">Enrollment Confirmed!</h2>
        <p>Hello {{ $data['student_name'] }},</p>
        <p>Your enrollment for the <strong>{{ $data['semester'] }}</strong> of School Year <strong>{{ $data['school_year'] }}</strong> has been confirmed.</p>
        
        <p>You have been enrolled in the following subjects:</p>
        <div style="background-color: #f9fafb; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($data['subjects'] as $subject)
                    <li style="margin-bottom: 5px;"><strong>{{ $subject->name }}</strong> ({{ $subject->code }})</li>
                @endforeach
            </ul>
        </div>

        <p>You can view your full schedule and attendance logs by logging into your portal account.</p>
        
        <a href="{{ config('app.url') }}/login" style="display: inline-block; background-color: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 10px;">Login to Portal</a>

        <p style="margin-top: 30px; font-size: 0.9em; color: #666;">
            Thank you,<br>
            School Administration
        </p>
    </div>
</body>
</html>
