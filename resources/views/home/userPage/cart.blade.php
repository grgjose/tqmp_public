<!DOCTYPE html>
<html lang="en">

<head>
    @include ('plus.head')
</head>
<style>
    .form-check-input {
        width: 28px !important;
        height: 28px !important;
        border: 3px solid #555 !important;
    }

    .form-check-input:checked {
        background-color: #dc3545 !important;
        /* red fill */
        border-color: #dc3545 !important;
    }

    .form-check-input:hover {
        border-color: #000 !important;
    }
</style>

<body>
    @include('plus.navbar')
    <div class="container py-5">
        <div class="row">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-lg-12 mb-4">
                <form id="checkoutForm" action="/checkout" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class=" p-3">
                        <h5 class="fw-bold">Order #{{ $my_user->id . date('ymdHis') }}</h5>
                        <input type="hidden" name="reference_num" value="{{ $my_user->id . date('ymdHis') }}">
                        <p class="text-muted">{{ date('jS F Y', strtotime('now')) }} at {{ date('h:i A') }}</p>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr class="text-muted">
                                        <th></th>
                                        <th>Product Details</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Price</th>
                                        <th>Discounted Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (count($carts) == 0)
                                        <tr>
                                            <td colspan="6">No Products Selected</td>
                                        </tr>
                                    @endif
                                    @foreach ($carts as $cart)
                                        @php
                                            $isExpiredQuotation = false;
                                            if ($cart->quotation_id) {
                                                $quotation = \App\Models\Quotation::find($cart->quotation_id);
                                                if ($quotation && $quotation->valid_until && \Carbon\Carbon::now()->greaterThan($quotation->valid_until) || ($quotation->status == 'Expired' || $quotation->status == 'Cancelled') ) {
                                                    $isExpiredQuotation = true;
                                                }
                                            }
                                        @endphp
                                        <tr class="{{ $isExpiredQuotation ? 'table-danger opacity-75' : '' }}">
                                            <td>
                                                <input type="checkbox" name="checkboxes[]" value="{{ $cart->id }}"
                                                    class="form-check-input" {{ $isExpiredQuotation ? 'disabled' : '' }}>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($cart->product_id != null)
                                                        @foreach ($productImages as $image)
                                                            @if ($image->product_id == $cart->product_id)
                                                                <img src="{{ asset('storage/all-items/' . $image->filename) }}"
                                                                    onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                                                    alt="Product" class="product-image me-3">
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @foreach ($products as $product)
                                                            @if ($product->id == $cart->product_id)
                                                                <div>
                                                                    <p class="mb-0 fw-bold">{{ $product->display_name }}
                                                                    </p>
                                                                    <small class="text-muted">Color: White | Size:
                                                                        Medium</small>
                                                                    <small style="display: none;"
                                                                        id="{{ $cart->id }}_price"
                                                                        class="text-muted">{{ $product->price }}</small>
                                                                    <input type="hidden"
                                                                        name="price_{{ $cart->id }}"
                                                                        class="hiddenPrice" value="{{ $cart->price }}">
                                                                </div>
                                                                @continue
                                                            @endif
                                                        @endforeach
                                                    @elseif($cart->quotation_id != null)
                                                        @foreach ($quotations as $quote)
                                                            @if ($quote->id == $cart->quotation_id)
                                                                <img src="{{ asset('storage/quotations/' . $quote->image) }}"
                                                                    onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                                                    alt="Quotation Image" class="product-image me-3">
                                                                <div>
                                                                    <p class="mb-0 fw-bold">Quotation:
                                                                        {{ $quote->reference }}</p>
                                                                    @if ($quote->quotation_type == 'bullet')
                                                                        <small class="text-muted">Bullet Proofing
                                                                            Quotation</small>
                                                                    @else
                                                                        <small class="text-muted">Glass Processing
                                                                            Quotation</small>
                                                                    @endif
                                                                    <small style="display: none;"
                                                                        id="{{ $cart->id }}_price"
                                                                        class="text-muted">{{ $quote->final_price }}</small>
                                                                    <input type="hidden"
                                                                        name="price_{{ $cart->id }}"
                                                                        class="hiddenPrice" value="">
                                                                </div>
                                                                @continue
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center" style="width: 60px;">
                                                @if ($cart->product_id != null)
                                                    <input type="number" name="quantity_{{ $cart->id }}"
                                                        class="form-control form-control-sm text-center"
                                                        value="{{ $cart->quantity }}" min="1">
                                                @elseif($cart->quotation_id != null)
                                                    <input type="number" name="quantity_{{ $cart->id }}"
                                                        class="form-control form-control-sm text-center"
                                                        value="{{ $cart->quantity }}" min="1" readonly>
                                                @endif
                                            </td>
                                            @if ($cart->product_id != null)
                                                @foreach ($products as $product)
                                                    @if ($product->id == $cart->product_id)
                                                        <td class="item_prices">₱{{ number_format($cart->price, 2) }}</td>
                                                        <td class="item_discounted_prices d-none">₱{{ number_format($cart->discounted_price, 2) }}</td>
                                                        <td class="prices">₱{{ number_format(($cart->price * $cart->quantity), 2) }}</td>
                                                        <td class="discounted_prices">₱{{ number_format(($cart->discounted_price * $cart->quantity), 2) }}</td>
                                                        @continue
                                                    @endif
                                                @endforeach
                                            @elseif($cart->quotation_id != null)
                                                @foreach ($quotations as $quote)
                                                    @if ($quote->id == $cart->quotation_id)
                                                        <td class="item_prices">₱{{ number_format($quote->final_price, 2) }}</td>
                                                        <td class="prices">
                                                            ₱{{ $quote->final_price * $cart->quantity }}</td>
                                                        <td class="discounted_prices">₱0.00</td>
                                                        @continue
                                                    @endif
                                                @endforeach
                                            @endif
                                            <td class="text-end">
                                                <span class="btn-close" style="cursor: pointer;"
                                                    onclick="removeItem(this, {{ $cart->id }})">&times;</span>
                                            </td>

                                            {{-- Add this warning badge if expired --}}
                                            @if($isExpiredQuotation)
                                                <td colspan="...">
                                                    <span class="badge bg-danger">Quotation Expired — Remove this item to proceed</span>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row pt-3">
                            <h5 class="fw-bold mb-1">Delivery Details</h5>
                            <p class="text-muted mb-3">Choose your delivery method</p>
                            <div class="col-md-12">
                                <div class="border rounded-4 p-4 mb-3 shadow-sm d-flex align-items-center">
                                    <input class="form-check-input me-3 mt-0" type="radio" name="delivery"
                                        value="pickup" id="option1" style="width: 25px; height: 25px;">
                                    <img src="https://tse1.mm.bing.net/th/id/OIP.hBdiffbPECOpw1Q91khrwAHaHa?rs=1&pid=ImgDetMain&o=7&rm=3"
                                        alt="Pick Up" class="rounded me-3"
                                        style="height: 55px; width: auto; object-fit: contain;">
                                    <label class="form-check-label flex-grow-1" for="option1">
                                        <p class="mb-1 fw-bold">Pick Up (Main Branch)</p>
                                        <small class="text-muted d-block">Expected Delivery: 2-3 days</small>
                                        <p class="mt-2 mb-0 text-success fw-semibold">Free</p>
                                    </label>
                                </div>

                                <div class="border rounded-4 p-4 shadow-sm d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        {{-- Pass whether user has a default shipping address --}}
                                        @php
                                            $hasShipping = \App\Models\Shipping::where('user_id', $my_user->id)
                                                                            ->where('isDefault', true)
                                                                            ->exists();
                                        @endphp
                                        {{-- Add a hidden field to tell JS --}}
                                        <input type="hidden" id="hasDefaultShipping" value="{{ $hasShipping ? '1' : '0' }}">
                                        <input class="form-check-input me-3 mt-0" type="radio" name="delivery"
                                            value="delivery" id="option2" style="width:25px;height:25px;">

                                        <img src="https://png.pngtree.com/recommend-works/png-clipart/20250101/ourmid/pngtree-orange-delivery-man-on-motorcycle-png-image_15017922.png"
                                            alt="Delivery" class="rounded me-3"
                                            style="height:55px;width:auto;object-fit:contain;">

                                        <label class="form-check-label mb-0" for="option2">
                                            <p class="mb-1 fw-bold">Delivery</p>
                                            <small class="text-muted d-block">Expected Delivery: 0-2 days</small>
                                            @if (count($shippings) == 0)
                                                <p class="mt-2 mb-0 text-danger fw-semibold">Set Shipping Address First
                                                </p>
                                            @else
                                                <small
                                                    class="text-muted d-block mt-2">{{ $shippings[0]->address }}</small>
                                                <p class="mt-2 mb-0 fw-semibold" id="deliveryFeePrice">
                                                    ₱{{ $shippings[0]->delivery_fee }}.00
                                                </p>
                                            @endif
                                        </label>
                                    </div>
                                    <a href="/set-shipping" class="btn btn-primary ms-3">Set Address</a>
                                </div>
                            </div>
                        </div>
                        <h5 class="fw-bold mt-4">Payment Methods</h5>
                        <p class="text-muted">Choose a payment method in your convenience</p>
                        <div class="col-md-12">
                            <div class="border rounded-4 p-4 mb-3 shadow-sm d-flex align-items-center">
                                <input class="form-check-input me-3 mt-0" type="radio" name="paymentMethod"
                                    value="onlinePayment" id="gateway" style="width: 25px; height: 25px;" disabled>
                                <label class="form-check-label flex-grow-1" for="gateway">
                                    <p class="mb-1 fw-bold">Online Payment via Payment Gateway</p>
                                    <small class="text-muted d-block">Pay Online using our Payment Gateway (Coming
                                        Soon)</small>
                                </label>
                            </div>
                            <div class="border rounded-4 p-4 shadow-sm d-flex align-items-center">
                                <input class="form-check-input me-3 mt-0" type="radio" name="paymentMethod"
                                    value="directTransfer" id="uploadPayment" checked
                                    style="width: 25px; height: 25px;">
                                <label class="form-check-label flex-grow-1" for="uploadPayment">
                                    <p class="mb-1 fw-bold">Upload Online Bank Payment (Direct Transfer)</p>
                                    <small class="text-muted d-block mb-3">Upload an attachment as proof of
                                        payment</small>
                                    <div class="bg-light rounded-3 p-3">
                                        <small class="d-block text-muted">
                                            <span class="fw-semibold">Bank Account Name:</span> TOTAL QUALITY MFG
                                            PRODUCTS PHIL
                                        </small>
                                        <small class="d-block text-muted">
                                            <span class="fw-semibold">BDO Unibank Account #:</span> 0039-0042-2278
                                        </small>
                                        <small class="d-block text-muted">
                                            <span class="fw-semibold">Metrobank Account #:</span> 1-6539-0665-0674
                                        </small>
                                    </div>
                                    <div class="mb-3 mt-3">
                                        <input type="file" name="proof" id="paymentAttachment"
                                            class="form-control form-control-sm attachmentRelated"
                                            accept="image/*,application/pdf" required>
                                        <small class="text-muted d-block mt-1">Accepted formats: JPG, PNG, PDF</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="container">
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="text-muted">Subtotal</p>
                    <p class="subtotal">₱0.00</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted">Shipping Cost (+)</p>
                    <p class="shipping-cost">₱0.00</p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="text-muted">Discount (-)</p>
                    <p class="discount">₱0.00</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="total-payable">Total Payable</p>
                    <p class="total-payable2">₱0.00</p>
                </div>
                <hr>
                <h6 class="coupon-text">Apply Coupon to get discount!</h6>
                <div class="input-group mb-3">
                    {{-- Add inside the <form> tag that submits to checkout --}}
                    <input type="hidden" id="couponCodeHidden" name="coupon_code" value="">
                    <input type="text" class="form-control" id="couponCodeInput" placeholder="Coupon code">
                    <button type="button" class="card-button btn btn-primary" onclick="applyCoupon()">Apply Code</button>
                </div>
                <div id="couponError" class="text-danger small mt-1" style="display:none;">
                    Coupon is Expired or Not Available.
                </div>
                <button type="submit" id="checkoutButton" class="card-button btn btn-danger w-100">Checkout</button>
            </div>
            </form>
        </div>
    </div>
</body>

@include('plus.scripts')
@include('plus.chatbot')
@include('plus.footer')

</html>
