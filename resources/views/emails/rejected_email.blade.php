<!DOCTYPE html>
<html>
<head>
    <title>TQMP | Account Approval</title>
</head>
<body>
    <h1>Dear {{ $data['name'] }},</h1>
    <p>{{ $data['message'] }}</p>
    <p>For any questions, feel free to contact our support team at <a href="mailto:support@tqmp.gissolve.com">support@tqmp.gissolve.com</a>.</p>
    <p>Best Regards</p>
    <p>TQMP Team</p>
    <a href="{{ config('app.url') }}">TQMP Website</a>
</body>
</html>