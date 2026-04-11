<!DOCTYPE html>
<html lang="en">
<head>
    @include('plus.head')
</head>
<body>
    @include('plus.navbar')
    <div class="container py-5 mt-5">
        <div class="container fade-in-up">
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
        </div>
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