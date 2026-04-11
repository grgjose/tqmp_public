<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    <h6 class="fw-bold mb-0 text-success">Thank you for shopping with us! For the meantime, here's your order status:</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <div class="container mb-5">
                <h6 class="mb-4">
                    @if($orders->isNotEmpty())
                        Order Reference Number: <span class="text-primary">{{ $orders[0]->reference_num }}</span>
                    @else
                        No orders found.
                    @endif
                </h6>
                <div class="d-flex justify-content-between align-items-center">

                    {{-- First Circle --}}
                    @if($orders[0]->status == 'Completed' || $orders[0]->status == 'Pending' || $orders[0]->status == 'Awaiting Payment'
                    || $orders[0]->status == 'Awaiting Fulfillment' || $orders[0]->status == 'Awaiting Pickup' || $orders[0]->status == 'Declined')
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <span>✓</span>
                        </div>
                        <div class="mt-1 small fw-bold">Order placed</div>
                    </div>
                    @else
                    <div class="text-center">
                        <div class="border rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <span>✓</span>
                        </div>
                        <div class="mt-1 small fw-bold">Order placed</div>
                    </div>
                    @endif

                    {{-- First Line --}}
                    @if($orders[0]->status == 'Completed' || $orders[0]->status == 'Pending' || $orders[0]->status == 'Awaiting Payment'
                    || $orders[0]->status == 'Awaiting Fulfillment' || $orders[0]->status == 'Awaiting Pickup' || $orders[0]->status == 'Declined')
                    <div class="flex-grow-1 mx-2">
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                    @else 
                    <div class="flex-grow-1 mx-2">
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    @endif


                    {{-- Second Circle --}}
                    @if($orders[0]->status == 'Completed' || $orders[0]->status == 'Pending' || $orders[0]->status == 'Awaiting Payment'
                    || $orders[0]->status == 'Awaiting Fulfillment' || $orders[0]->status == 'Awaiting Pickup' || $orders[0]->status == 'Declined')
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <span>✓</span>
                        </div>
                        <div class="mt-1 small">Processing</div>
                    </div>
                    @else
                    <div class="text-center">
                        <div class="border rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <span>✓</span>
                        </div>
                        <div class="mt-1 small">Processing</div>
                    </div>
                    @endif

                    {{-- Second Line --}}
                    @if($orders[0]->status == 'Completed' || $orders[0]->status == 'Pending' || $orders[0]->status == 'Awaiting Payment'
                    || $orders[0]->status == 'Awaiting Fulfillment' || $orders[0]->status == 'Awaiting Pickup' || $orders[0]->status == 'Declined')
                    <div class="flex-grow-1 mx-2">
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                    @else 
                    <div class="flex-grow-1 mx-2">
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    @endif

                    {{-- Third Circle --}}
                    @if($orders[0]->status == 'Completed' || $orders[0]->status == 'Pending' || $orders[0]->status == 'Awaiting Payment'
                    || $orders[0]->status == 'Awaiting Fulfillment' || $orders[0]->status == 'Awaiting Pickup' || $orders[0]->status == 'Declined')
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <span>✓</span>
                        </div>
                        <div class="mt-1 small">Shipping</div>
                    </div>
                    @else
                    <div class="text-center">
                        <div class="border rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <span>✓</span>
                        </div>
                        <div class="mt-1 small">Shipping</div>
                    </div>
                    @endif

                    {{-- Third Line --}}
                    @if($orders[0]->status == 'Completed' || $orders[0]->status == 'Pending' || $orders[0]->status == 'Awaiting Payment'
                    || $orders[0]->status == 'Awaiting Fulfillment' || $orders[0]->status == 'Awaiting Pickup' || $orders[0]->status == 'Declined')
                    <div class="flex-grow-1 mx-2">
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                    @else 
                    <div class="flex-grow-1 mx-2">
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                    @endif

                    {{-- Fourth Circle --}}
                    @if($orders[0]->status == 'Completed' || $orders[0]->status == 'Pending' || $orders[0]->status == 'Awaiting Payment'
                    || $orders[0]->status == 'Awaiting Fulfillment' || $orders[0]->status == 'Awaiting Pickup' || $orders[0]->status == 'Declined')
                    <div class="text-center">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <span>✓</span>
                        </div>
                        <div class="mt-1 small">Delivered</div>
                    </div>
                    @else
                    <div class="text-center">
                        <div class="border rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 30px; height: 30px;">
                            <span>✓</span>
                        </div>
                        <div class="mt-1 small">Delivered</div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-12">
                <h6 class="mb-3">Order Details</h6>
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr class="text-muted">
                                <th>Product</th>
                                <th>Quantity</th>
                                <th class="text-end">Price</th>
                            </tr>
                        </thead>
                        @php
                        $subtotal = 0;
                        @endphp
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                @if($order->p_name == "" || $order->p_name == null)
                                    <td>{{ $order->q_name }}</td>
                                @else
                                    <td>{{ $order->p_name }}</td>
                                @endif
                                <td>{{ $order->quantity }}</td>
                                <td class="text-end">₱{{ $order->price }}</td>
                                <span style="display: none;">
                                    @php
                                    $subtotal += $order->price;
                                    @endphp
                                </span>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">SubTotal</td>
                                <td class="text-end fw-bold">₱{{ $subtotal }}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Shipping Cost</td>
                                <td class="text-end fw-bold">₱0.00</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total</td>
                                <td class="text-end fw-bold">₱{{ $subtotal }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
            <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('#orderDetailsTable').DataTable({
                        paging: false,
                        searching: false,
                        info: false,
                        ordering: false
                    });
                });
            </script>
        </div>
    </div>
    <script>
        function removeItem(element) {
            const row = element.closest('tr');
            if (row) {
                row.remove();
            }
        }
    </script>
</body>
@include ('plus.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>
</html>