<!DOCTYPE html>
<html>
<head>
    <title>TQMP | Forgot Password</title>
</head>
<body>
    <h1>Dear {{ $data['name'] }},</h1>
    <p>{{ $data['message'] }}</p>
    <p>Reset Password Link: <a href="{{ config('app.url') }}/reset/{{ $data['token'] }}">Password Reset Link<a></p>
    <p>If you did not request for this password, Please delete this email from the inbox and trash bin <br> then, secure your account or change your password immediately.</p>
    <p>For any questions, feel free to contact our support team at <a href="mailto:support@tqmp.gissolve.com">support@tqmp.gissolve.com</a>.</p>
    <p>Best Regards</p>
    <p>TQMP Team</p>
    <a href="{{ config('app.url') }}">TQMP Website</p>
</body>
</html>