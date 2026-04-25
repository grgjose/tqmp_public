<!DOCTYPE html>
<html lang="en">
<head>
    @include('plus.head')
</head>
<body>
    @include('plus.navbar')
    <div class="container py-5 mt-5">
        {{-- <div class="container fade-in-up">
            <h3 class="fw-bold">Order Status</h3>
            <div class="p-3 my-5 bg-light border-border-primary shadow-sm rounded">
                <table class="table table-striped nowrap" id="ordersTable">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Item</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($orders) == 0)
                        <tr>
                            <td colspan="5" class="text-center py-3">No available data</td>
                        </tr>
                        @endif
                        @foreach($orders as $order)
                        <tr>
                            <td><a href="/order-status/{{ $order->reference_num }}">{{ $order->reference_num }}</a></td>
                            <td>{{ $order->display_name }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td><span class="text-success">{{ ucfirst($order->status) }}</span></td>
                            <td>₱{{ $order->price }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
        {{-- ── Order Items & Actions Table ──────────────────────────────────── --}}
        @if($orders->isNotEmpty())
        @php $firstOrder = $orders[0]; @endphp
        <div class="mt-5">
            <h5 class="fw-bold mb-3">Order Details</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($order->product_id)
                                    {{ $order->product_id ? $order->display_name : '—' }}
                                @elseif($order->quotation_id)
                                    Quotation: {{ $order->reference_num }}
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $order->quantity }}</td>
                            <td>₱{{ number_format($order->price, 2) }}</td>
                            <td>
                                <span class="badge
                                    @if($order->status == 'Completed') bg-success
                                    @elseif($order->status == 'Pending') bg-warning text-dark
                                    @elseif(in_array($order->status, ['Cancelled', 'Declined', 'Refunded'])) bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2 flex-wrap">
                                    {{-- Download Acknowledgement Receipt --}}
                                    @if($order->proof_of_payment)
                                    <a href="/order-download-ar/{{ $order->id }}"
                                    class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-receipt"></i> Download AR
                                    </a>
                                    @else
                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                        <i class="fa-solid fa-receipt"></i> AR Pending
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
            <div class="alert alert-info">No orders found for this reference.</div>
        @endif
    </div>
    <script>
        function AddtoCartUpdateModal(id) {
            $("#quotation_id_modal").val(id);
        }
        let table = new DataTable('#quotationsTable', {
            lengthChange: false,
            responsive: true
        });
    </script>
    @include ('plus.chatbot')
    @include ('plus.footer')
    @include ('plus.scripts')
</body>
</html>