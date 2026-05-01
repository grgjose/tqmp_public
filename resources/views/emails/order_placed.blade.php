<!DOCTYPE html>
<html>
<head>
    <title>TQMP | Order Placed</title>
</head>
<body>
    <h1>Hi Sales Team,</h1>
    <p>A new order has just been placed on the TQMP - Web App. Below are the order details:</p>

    @php
        $order = $data['order'];
        $items = $data['items'];
        $user  = $data['user'];
    @endphp

    <p><strong>Order Information</strong></p>
    <p>-----------------</p>
    <p>Reference: {{ $data['reference_num'] }}</p>
    <p>Order Date: {{ $data['date'] }}</p>
    <p>Delivery Type: {{ ucfirst($order->delivery_type) }}</p>
    <p>Order Status: {{ $order->status }}</p>

    <p><strong>Customer Information</strong></p>
    <p>-----------------</p>
    <p>Name: {{ $user->fname . ' ' . $user->lname }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Phone: {{ $user->contact_num }}</p>
    <p>Shipping Address: {{ $order->shipping_address }}</p>

    <h3>🛍️ Items Ordered:</h3>
    <table cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 100%;">
        <thead style="background-color: #f2f2f2;">
            <tr>
                <th style="border: 1px solid #ddd;">Item</th>
                <th style="border: 1px solid #ddd;">Type</th>
                <th style="border: 1px solid #ddd;">Quantity</th>
                <th style="border: 1px solid #ddd;">Unit Price</th>
                <th style="border: 1px solid #ddd;">Line Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td style="border: 1px solid #ddd;">
                    @if($item->product)
                        {{ $item->product->display_name ?? $item->product->name }}
                    @elseif($item->quotation)
                        Quotation: {{ $item->quotation->reference }}
                    @else
                        —
                    @endif
                </td>
                <td style="border: 1px solid #ddd;">
                    {{ $item->product_id ? 'Product' : 'Quotation' }}
                </td>
                <td style="border: 1px solid #ddd;">{{ $item->quantity }}</td>
                <td style="border: 1px solid #ddd;">
                    ₱{{ number_format($item->discounted_price ?? $item->unit_price, 2) }}
                </td>
                <td style="border: 1px solid #ddd;">
                    ₱{{ number_format(($item->discounted_price ?? $item->unit_price) * $item->quantity, 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @php
        $subtotal = $items->sum(fn($i) => ($i->discounted_price ?? $i->unit_price) * $i->quantity);
        $shipping = 0.00;
        $tax      = 0.00;
        $total    = $subtotal + $shipping + $tax;
    @endphp

    <br>
    <p><strong>Subtotal:</strong> ₱{{ number_format($subtotal, 2) }}</p>
    <p><strong>Shipping:</strong> ₱{{ number_format($shipping, 2) }}</p>
    <p><strong>Tax:</strong> ₱{{ number_format($tax, 2) }}</p>
    <p><strong>Total: ₱{{ number_format($total, 2) }}</strong></p>

    <p>Please see the Admin Dashboard to monitor the Order Details.</p>
    <p>For any questions, feel free to contact our support team at
        <a href="mailto:support@tqmp.gissolve.com">support@tqmp.gissolve.com</a>.
    </p>
    <p>Best Regards</p>
    <p>TQMP Team</p>
    <a href="{{ config('app.url') }}">TQMP Website</a>
</body>
</html>