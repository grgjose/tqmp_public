        <main class="app-main px-4">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
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
                                    <td>₱{{ $order->price }}.00</td>
                                    <td id="quantity{{$order->id}}">{{ $order->quantity }}</td>
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
                                                @if($order->lalamove_order == null)
                                                <li><a class="dropdown-item" href="#" data-bs-target="#quotationModal" onclick="getQuotation({{ $order->id }})">Place Lalamove Order</a></li>
                                                @else
                                                <li><a class="dropdown-item" href="#" data-bs-target="#orderDetailsModal" onclick="getOrderDetails({{ $order->id }})">Order Details</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#cancelOrderModal" onclick="cancelOrder({{ $order->id }})">Cancel Order</a></li>
                                                @endif
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
                    <form method="POST" action="/order-place-order">
                        <div class="modal-body">
                            <p id="lalamoveCost">The estimated delivery cost is <strong>₱150.00</strong>.</p>
                            @csrf
                            <input type="hidden" name="order_id" id="order_id">
                            <!-- Vehicle selection combo box -->
                            <div class="mt-3">
                                <label for="vehicleSelect" class="form-label fw-semibold">Choose Vehicle:</label>
                                <select class="form-select" id="vehicleSelect" name="vehicle">
                                    <option value="MOTORCYCLE">Motorcycle</option>
                                    <option value="SEDAN" selected>Sedan</option>
                                    <option value="MPV">MPV (Multi-Purpose Vehicle)</option>
                                    <option value="VAN">Van</option>
                                    <option value="10WHEEL_TRUCK">Truck</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Place Order</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-secondary">
                    <div class="modal-header bg-secondary text-white">
                        <h5 class="modal-title" id="cancelOrderModalLabel">Order Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p id="status">Status: </p>
                        <p id="link">Share Link: </p>
                        <p id="driverName">Driver Name: </p>
                        <p id="driverContact">Driver Contact: </p>
                        <p id="driverPlateNumber">Driver Plate Number: </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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