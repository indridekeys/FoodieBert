<!DOCTYPE html>
<html>
<head>
    <title>FoodieBert Access</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        <h2 style="color: #2d3748;">Welcome to the FoodieBert, {{ $name }}!</h2>
        <p>Your registration is almost complete. Please use the details below to verify your account.</p>
        
        <div style="background: #f7fafc; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>Your Matricule:</strong> <span style="color: #e53e3e;">{{ $matricule }}</span></p>
            <p style="margin: 5px 0;"><strong>Verification Code:</strong></p>
            <h1 style="letter-spacing: 5px; color: #2b6cb0; margin: 10px 0;">{{ $code }}</h1>
        </div>

        <p>If you did not request this, please ignore this email.</p>
        <hr style="border: 0; border-top: 1px solid #eee;">
        <p style="font-size: 0.8em; color: #718096;">&copy; 2026 FoodieBert Empire. All rights reserved.</p>
    </div>
</body>
</html>