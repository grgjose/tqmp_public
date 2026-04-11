<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')
    <div class="container my-5">
        <h2 class="mb-4 checkout-title fw-bold">Checkout</h1>
        <div class="row">
            <div class="col-lg-7">
                <h4 class="mb-3">Billing Details</h4>
                <form>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstName" class="form-label">First name*</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastName" class="form-label">Last name*</label>
                            <input type="text" class="form-control" id="lastName" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address*</label>
                        <input type="text" class="form-control" id="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="address2" class="form-label">Address line 2</label>
                        <input type="text" class="form-control" id="address2">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="country" class="form-label">Country*</label>
                            <select id="country" class="form-select" required>
                                <option selected>Choose...</option>
                                <option>Philippines</option>
                                <option>United States</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">City/Town*</label>
                            <input type="text" class="form-control" id="city" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="postcode" class="form-label">Postcode / ZIP*</label>
                            <input type="text" class="form-control" id="postcode" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone*</label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="additionalInfo" class="form-label">Additional Information</label>
                        <textarea id="additionalInfo" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="createAccount">
                        <label class="form-check-label" for="createAccount">
                            Create Account
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="differentAddress">
                        <label class="form-check-label" for="differentAddress">
                            Ship to a different address?
                        </label>
                    </div>
                    <h6 class="coupon-text">Apply Coupon to get discount!</h6>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Coupon code">
                        <button class="card-button btn btn-primary">Apply Code</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-5">
                <h4 class="mb-3">Your Order</h4>
                <div class="border p-3">
                    <strong>Product</strong>
                </div>
                <ul class="list-group list-group-flush border">
                    <li class="list-group-item d-flex align-items-center justify-content-between border-bottom">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/50" alt="Product" class="me-3">
                            <div>
                                <span>Aluminum Glass</span><br>
                                <small>Brown XL x 1</small>
                            </div>
                        </div>
                        <span>$36.00</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center justify-content-between border-bottom">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/50" alt="Product" class="me-3">
                            <div>
                                <span>Windows</span><br>
                                <small>Brown XL x 1</small>
                            </div>
                        </div>
                        <span>$36.00</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center justify-content-between border-bottom">
                        <div class="d-flex align-items-center">
                            <img src="https://via.placeholder.com/50" alt="Product" class="me-3">
                            <div>
                                <span>Sliding Door</span><br>
                                <small>Brown XL x 1</small>
                            </div>
                        </div>
                        <span>$36.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-bottom">
                        <strong>Subtotal</strong>
                        <strong>$108.00</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-bottom">
                        <span>Shipping Cost (+)</span>
                        <span>$10.85</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between border-bottom">
                        <span>Discount (-)</span>
                        <span>$9.00</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <strong>Total Payable</strong>
                        <strong>$88.15</strong>
                    </li>
                </ul>
                <div class="border p-3 mt-4">
                    <strong>Payment</strong>
                </div>
                <ul class="list-group list-group-flush border">
                    <li class="list-group-item border-bottom">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="bankTransfer" checked>
                            <label class="form-check-label" for="bankTransfer">
                                Direct Bank Transfer
                            </label>
                        </div>
                    </li>
                    <li class="list-group-item border-bottom">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cod">
                            <label class="form-check-label" for="cod">
                                Cash on delivery
                            </label>
                        </div>
                    </li>
                    <li class="list-group-item border-bottom">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="onlinePayment">
                            <label class="form-check-label" for="onlinePayment">
                                Online Gateway
                            </label>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <button class="card-button btn btn-primary mt-auto w-100">Place Order</button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
    @include ('plus.scripts')
    <!-- @include ('plus.cta') -->
    @include ('plus.accordion')
    @include('plus.chatbot')
    @include ('plus.footer')
</html>