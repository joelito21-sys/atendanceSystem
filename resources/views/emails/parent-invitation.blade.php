<!DOCTYPE html>
<html>
<head>
    <title>Parent Portal Access</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; rounded: 8px;">
        <h2 style="color: #4f46e5;">Welcome to our School Portal!</h2>
        <p>Hello,</p>
        <p>An account has been created for you as a parent/guardian. You can now log in to the system to monitor your child's attendance and grades.</p>
        
        <div style="background-color: #f9fafb; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0; font-weight: bold;">Login Credentials:</p>
            <p style="margin: 5px 0;"><strong>Email:</strong> {{ $data['email'] ?? 'Your Email' }}</p>
            <p style="margin: 5px 0;"><strong>Password:</strong> {{ $data['temp_password'] }}</p>
        </div>

        <p>Please log in and change your password as soon as possible for security purposes.</p>
        
        <a href="{{ config('app.url') }}/login" style="display: inline-block; background-color: #4f46e5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; margin-top: 10px;">Login to Portal</a>

        <p style="margin-top: 30px; font-size: 0.9em; color: #666;">
            Thank you,<br>
            School Administration
        </p>
    </div>
</body>
</html>
