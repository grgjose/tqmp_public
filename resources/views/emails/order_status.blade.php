<!DOCTYPE html>
<html>
<head>
    <title>TQMP | Order Status</title>
</head>
<body>
    <h1>Dear {{ $data['name'] }},</h1>
    <p>Your Order has been placed.</p>
    <p>You can monitor your order status thru your Profile.</p>
    <p>For any questions, feel free to contact our support team at <a href="mailto:support@tqmp.gissolve.com">support@tqmp.gissolve.com</a>.</p>
    <p>Best Regards</p>
    <p>TQMP Team</p>
    <a href="{{ config('app.url') }}">TQMP Website</p>
</body>
</html>