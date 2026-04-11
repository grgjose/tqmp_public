<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Total Quality Management Products Philippines">
    <meta name="author" content="TQMP">
    <title>Order Status | Total Quality Management Products Philippines</title>
    <link rel="icon" href="{{ asset('storage/logos/TQMPLogo.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/chatbot.css') }}">
    <script src="{{ asset('js/chatbot.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>
    @include('plus.navbar')
    <div class="container py-5">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="alert alert-success text-center" role="alert">
                    <h5 class="fw-bold mb-0 text-success">Thank you for shopping with us! For the meantime, here's your order status:</h5>
                </div>
            </div>
            <div class="col-12 mb-4">
                <div class="d-flex justify-content-around">
                    <div class="text-center">
                        <p class="fw-bold">Preparing</p>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="fw-bold">Packing</p>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="fw-bold">Ready for Pickup</p>
                        <div class="progress" style="height: 5px;">
                            <div class="progress-bar bg-secondary" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <h5 class="fw-bold mb-3">Order Details</h5>
                <div class="table-responsive">
                    <table id="orderDetailsTable" class="table">
                        <thead>
                            <tr class="text-muted">
                                <th>Product</th>
                                <th>Quantity</th>
                                <th class="text-end">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Aluminum Glass</td>
                                <td class="text-center">1</td>
                                <td class="text-end">₱36.00</td>
                            </tr>
                            <tr>
                                <td>Windows</td>
                                <td class="text-center">1</td>
                                <td class="text-end">₱25.00</td>
                            </tr>
                            <tr>
                                <td>Sliding Door</td>
                                <td class="text-center">1</td>
                                <td class="text-end">₱25.00</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end fw-bold">Total</td>
                                <td class="text-end fw-bold">₱86.00</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
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
@include ('plus.scripts')
@include ('plus.footer')
</html>