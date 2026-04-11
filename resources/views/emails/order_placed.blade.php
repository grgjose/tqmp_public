<!DOCTYPE html>
<html>
<head>
    <title>TQMP | Order Placed</title>
</head>
<body>
    <h1>Hi Sales Team,</h1>
    <p>A new order has just been placed on the TQMP - Web App. Below are the order details:</p>
    @php
        $orders = $data['orders'];
        $user = $data['user'];
    @endphp
    <p>Order Information</p>
    <p>-----------------</p>
    <p>Reference: {{ $data['reference_num'] }}</p>
    <p>Order Date: {{ $data['date'] }}</p>
    <p>Payment Method: Direct Bank Transfer</p>
    <p>Order Status: Order Placed</p>
    <p>Customer Information</p>
    <p>-----------------</p>
    <p>Name: {{ $user->fname.' '.$user->lname }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Phone: {{ $user->contact_num }}</p>
    <p>Shipping Address: {{ $user->address }}</p>
    <h3>🛍️ Items Ordered:</h3>
    <table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
    <thead style="background-color: #f2f2f2;">
        <tr>
        <th>Item</th>
        <th>Display Name</th>
        <th>Quantity</th>
        <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>{{ $order->product_name }}</td>
            <td>{{ $order->product_display_name }}</td>
            <td>{{ $order->quantity }}</td>
            <td>₱{{ $order->price }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>
    @php
        $subtotal = 0.00;
        $shipping = 0.00;
        $tax = 0.00;
        $total = 0.00;
        foreach($orders as $order){
            $subtotal = $subtotal + $order->price;
        }
        $total = $subtotal + $shipping + $tax;
    @endphp
    <p><strong>Subtotal:</strong> ₱{{ $subtotal }}</p>
    <p><strong>Shipping:</strong> ₱{{ $shipping }}</p>
    <p><strong>Tax:</strong> ₱{{ $tax }}</p>
    <p><strong>Total:</strong> <strong>₱{{ $total }}</strong></p>
    <p>Please see Admin Dashboard to monitor the Order Details.</p>
    <p>For any questions, feel free to contact our support team at <a href="mailto:support@tqmp.gissolve.com">support@tqmp.gissolve.com</a>.</p>
    <p>Best Regards</p>
    <p>TQMP Team</p>
    <a href="{{ config('app.url') }}">TQMP Website</a>
</body>
</html>