        <main class="app-main px-4">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Orders</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Orders</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="card tbl">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Customer's Order List</h4>
                    </div>
                    <div class="card-body">
                        <table id="tbl_orders" class="table is-striped" style="width:100%; text-align: left;">
                            <thead>
                                <tr>
                                    <th style="width: 10%">Order ID</th>
                                    <th style="width: 10%">Product Name</th>
                                    <th style="width: 10%">Customer</th>
                                    <th style="width: 10%">Sales Rep</th>
                                    <th style="width: 15%">Shipping Address</th>
                                    <th style="width: 7%">Price</th>
                                    <th style="width: 5%">Quantity</th>
                                    <th style="width: 13%">Status</th>
                                    <th style="width: 10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td><a href="#">{{ $order->reference_num }}</a></td>
                                    <td>{{ $order->product_name }}</td>
                                    <td>{{ $order->customer_fullname }}</td>
                                    <td>{{ $order->sales_rep_fullname }}</td>
                                    <td>{{ $order->shipping_address }}</td>
                                    <td>PHP {{ $order->price }}</td>
                                    <td>{{ $order->quantity }}</td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="statusButton{{$order->id}}">
                                                {{ $order->status }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Pending</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Awaiting Payment</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Awaiting Fulfillment</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Awaiting Shipment</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Awaiting Shipped</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Partially Shipped</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Awaiting Pickup</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Completed</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Shipped</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Cancelled</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Declined</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Refunded</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Disputed</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Manual Verification Required</a></li>
                                                <li><a class="dropdown-item" href="#" onclick="changeStatus({{$order->id}}, this.innerText)">Partially Refunded</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#" data-bs-target="#quotationModal" onclick="getQuotation({{ $order->id }})">Get Lalamove Quotation</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#placeOrderModal" onclick="placeOrder({{ $order->id }})">Place Order</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" onclick="cancelOrder({{ $order->id }})">Cancel Order</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <div class="modal fade" id="quotationModal" tabindex="-1" aria-labelledby="quotationModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quotationModalLabel">Lalamove Quotation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>The estimated delivery cost is <strong>₱150.00</strong>.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="placeOrderModal" tabindex="-1" aria-labelledby="placeOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="placeOrderModalLabel">Confirm Order Placement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to place this Lalamove order?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-success" id="confirmPlaceOrder">Yes, Place Order</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-danger">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>This order is <strong>non-refundable</strong>. Are you sure you want to cancel?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" id="confirmCancelOrder">Yes, Cancel Order</button>
                    </div>
                </div>
            </div>
        </div>
        <form action="" method="POST" style="display: none;" id="changeStatusForm">
            @csrf
            <input type="hidden" name="status" id="changeStatusInput">
        </form>
        <div id="loadingOverlay" style="display: none; position: fixed; z-index: 1055; top: 0; left: 0;
            width: 100vw; height: 100vh; background: rgba(0,0,0,0.5); backdrop-filter: blur(2px);
            align-items: center; justify-content: center;">
            <div class="spinner-border text-light" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <script>

            function showLoader() {
                document.getElementById('loadingOverlay').style.display = 'flex';
            }

            function hideLoader() {
                document.getElementById('loadingOverlay').style.display = 'none';
            }

            function changeStatus(id, status){
                $('#changeStatusForm').attr('action', '/order-status-change/'+id);
                $('#changeStatusInput').val(status);
                $('#changeStatusForm').submit();
                $('#statusButton').html(status);
            }

            async function getQuotationTotal(apiUrl) {
            try {
                // Call the API with GET method
                const response = await fetch(apiUrl, {
                    method: "GET",
                    headers: {
                        "Content-Type": "application/json",
                        "XCSRFToken": "{{ csrf_token() }}"
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                // Parse JSON response
                const result = await response.json();

                // Ensure structure exists
                if (result?.data?.priceBreakdown?.total) {
                    const total = parseFloat(result.data.priceBreakdown.total);
                    console.log("Quotation Total:", total);
                    return total;
                } else {
                    throw new Error("priceBreakdown.total not found in response");
                }

            } catch (error) {
                console.error("Error fetching quotation:", error.message);
                return null;
            }
            }

            function getQuotation(orderId) {
                showLoader();

                // Do your real logic here, like fetch order details
                getQuotationTotal('/order-get-quotation/' + orderId)
                    .then(total => {
                        if (total !== null) {
                            // Update the modal content with the fetched total
                            document.querySelector('#quotationModal .modal-body').innerHTML = `<p>The estimated delivery cost is <strong>₱${total.toFixed(2)}</strong>.</p>`;
                        } else {
                            // Handle error case
                            document.querySelector('#quotationModal .modal-body').innerHTML = `<p>Error fetching quotation. Please try again later.</p>`;
                        }
                    });


                // Simulate async delay (or use fetch/axios here)
                setTimeout(() => {

                    hideLoader(); // hide the loading spinner

                    // Now show the modal
                    let myModal = new bootstrap.Modal(document.getElementById('quotationModal'));
                    myModal.show();


                }, 1000); // simulate 1-second delay
            }
            
            function placeOrder(orderId) {
                $('#confirmPlaceOrder').off('click').on('click', function() {
                    console.log("Placing order for order ID:", orderId);
                    $('#placeOrderModal').modal('hide');
                });
            }
            function cancelOrder(orderId) {
                $('#confirmCancelOrder').off('click').on('click', function() {
                    console.log("Cancelling order for order ID:", orderId);
                    $('#cancelOrderModal').modal('hide');
                });
            }
        </script>