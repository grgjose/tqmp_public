<!DOCTYPE html>
<html>
<head>
    <title>TQMP | User Creation</title>
</head>
<body>
    <h1>Dear {{ $data['name'] }},</h1>
    <p>Thank you for signing up with TQMP! Since the Admin created your Account</p>
    <p>{{ $data['message'] }}</p>
    <p>This is your random password: {{ $data['password'] }}</p>
    <p>For any questions, feel free to contact our support team at <a href="mailto:support@tqmp.gissolve.com">support@tqmp.gissolve.com</a>.</p>
    <p>Best Regards</p>
    <p>TQMP Team</p>
    <a href="{{ config('app.url') }}">TQMP Website</a>
</body>
</html>