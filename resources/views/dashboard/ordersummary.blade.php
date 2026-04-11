<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Total Quality Management Products Philippines">
    <meta name="author" content="TQMP">
    <title>Checkout | Total Quality Management Products Philippines</title>
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
            <div class="col-md-7 mb-4">
                <h5 class="fw-bold">Order #15478</h5>
                <p class="text-muted">21st March 2021 at 10:34 PM</p>
                <div class="border rounded-3 p-3">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="text-muted">
                                    <th>Product Details</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://th.bing.com/th/id/R.bd7ec57205f5f8bea1aa148c3f44583d?rik=jxr7IaKBvhlUZw&riu=http%3a%2f%2fwww.richmondtopglass.com%2fwp-content%2fuploads%2f2018%2f05%2falum.png&ehk=iTUYxOJWwRo9yxGvVzyto5FcqTcl8EZlLmNF7Hix0FA%3d&risl=&pid=ImgRaw&r=0" alt="Product" class="product-image me-3">
                                            <div>
                                                <p class="mb-0 fw-bold">Aluminum Glass</p>
                                                <small class="text-muted">Color: White | Size: Medium</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 60px;">
                                        <input type="number" class="form-control form-control-sm text-center" value="1" min="1">
                                    </td>
                                    <td class="text-end">₱36.00</td>
                                    <td class="text-end"> <span class="btn-close" style="cursor: pointer;" onclick="removeItem(this)">&times;</span></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://th.bing.com/th/id/R.bd7ec57205f5f8bea1aa148c3f44583d?rik=jxr7IaKBvhlUZw&riu=http%3a%2f%2fwww.richmondtopglass.com%2fwp-content%2fuploads%2f2018%2f05%2falum.png&ehk=iTUYxOJWwRo9yxGvVzyto5FcqTcl8EZlLmNF7Hix0FA%3d&risl=&pid=ImgRaw&r=0" alt="Product" class="product-image me-3">
                                            <div>
                                                <p class="mb-0 fw-bold">Windows</p>
                                                <small class="text-muted">Color: Pest | Size: Large</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 60px;">
                                        <input type="number" class="form-control form-control-sm text-center" value="1" min="1">
                                    </td>
                                    <td class="text-end">₱25.00</td>
                                    <td class="text-end"> <span class="btn-close" style="cursor: pointer;" onclick="removeItem(this)">&times;</span></td>
                                </tr>
                                <tr class="item">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="https://th.bing.com/th/id/R.bd7ec57205f5f8bea1aa148c3f44583d?rik=jxr7IaKBvhlUZw&riu=http%3a%2f%2fwww.richmondtopglass.com%2fwp-content%2fuploads%2f2018%2f05%2falum.png&ehk=iTUYxOJWwRo9yxGvVzyto5FcqTcl8EZlLmNF7Hix0FA%3d&risl=&pid=ImgRaw&r=0" alt="Product" class="product-image me-3">
                                            <div>
                                                <p class="mb-0 fw-bold">Sliding Door</p>
                                                <small class="text-muted">Color: Yellow | Size: Medium</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center" style="width: 60px;">
                                        <input type="number" class="form-control form-control-sm text-center" value="1" min="1">
                                    </td>
                                    <td class="text-end">₱25.00</td>
                                    <td class="text-end">
                                        <span class="btn-close" style="cursor: pointer;" onclick="removeItem(this)">&times;</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <p class="text-muted">Subtotal</p>
                        <p>₱106</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="text-muted">Shipping Cost (+)</p>
                        <p>₱10.85</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p class="text-muted">Discount (-)</p>
                        <p>₱9.00</p>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <p class="total-payable">Total Payable</p>
                        <p class="total-payable">₱107.85</p>
                    </div>
                    <h6 class="coupon-text">Apply Coupon to get discount!</h6>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Coupon code">
                        <button class="card-button btn btn-primary">Apply Code</button>
                    </div>
                </div>
            </div>
            <div class="col-md-5 mb-4">
                <h5 class="fw-bold">Delivery Details</h5>
                <p class="text-muted">Delivery mode in your convenience</p>
                <div class="container">
                    <div class="row">
                        <div class="border rounded-3 p-3 d-flex align-items-center">
                            <input class="form-check-input me-3" type="radio" name="deliveryOption" id="option1">
                            <img src="https://th.bing.com/th/id/OIP.Dl-WiroGReI7sZ13Bp5U1gHaHa?rs=1&pid=ImgDetMain" alt="Product" class="product-image me-3" style="height: 50px; width: auto;">
                            <label class="form-check-label" for="option1">
                                <p class="mb-0 fw-bold">Sample Delivery Company</p>
                                <small class="text-muted">Expected Delivery: *insert date*</small>
                                <p class="mt-2">₱36.00</p>
                            </label>
                        </div>
                        <div class="border rounded-3 p-3 mt-3 d-flex align-items-center">
                            <input class="form-check-input me-3" type="radio" name="deliveryOption" id="option1">
                            <img src="https://th.bing.com/th/id/R.ceca21e2c4adf86765ad827513550427?rik=MHwhFqcmy9sM8Q&pid=ImgRaw&r=0" alt="Product" class="product-image me-3" style="height: 50px; width: auto;">
                            <label class="form-check-label" for="option1">
                                <p class="mb-0 fw-bold">Pick Up (Main Branch)</p>
                                <small class="text-muted">Expected Delivery: *insert date*</small>
                                <p class="mt-2">Free</p>
                            </label>
                        </div>
                    </div>
                </div>
                <h5 class="fw-bold mt-4">Payment Methods</h5>
                <p class="text-muted">Choose a payment method in your convenience</p>
                <div class="container">
                    <div class="row">
                        <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 fw-bold">Direct Bank Transfer</p>
                                <small class="text-muted">Transfer directly to our bank account.</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer">
                            </div>
                        </div>
                        <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 fw-bold">Cash on Delivery</p>
                                <small class="text-muted">Pay when you receive the product.</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="cod">
                            </div>
                        </div>
                        <div class="border rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                            <div>
                                <p class="mb-0 fw-bold">Online Gateway</p>
                                <small class="text-muted">Pay securely through our online payment gateway.</small>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="radio" name="paymentMethod" id="onlinePayment">
                            </div>
                        </div>
                    <button type="submit" class="card-button btn btn-primary btn-lg w-100 mb-4 mt-3">Add to Cart</button>
                    </div>
                </div>
            </div>
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
</html>