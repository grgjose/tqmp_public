<!DOCTYPE html>
<html>
<head>
    <title>TQMP | Email Confirmation</title>
</head>
<body>
    <h1>Dear {{ $data['name'] }},</h1>
    <p>{{ $data['message'] }}</p>
    <p>Thank you for signing up with TQMP! To complete your registration, please confirm your email address by clicking the link below:</p>
    <a href="{{ config('app.url') }}/confirmation/{{ $data['email_token'] }}">Email Verification<a> 
    <p>{{ $data['message'] }}</p>
    <p>If you didn't create an account, please ignore this email. This link will expire in 7 days.</p>
    <p>For any questions, feel free to contact our support team at <a href="mailto:support@tqmp.gissolve.com">support@tqmp.gissolve.com</a>.</p>
    <p>Best Regards</p>
    <p>TQMP Team</p>
    <a href="{{ config('app.url') }}">TQMP Website</p>
</body>
</html>