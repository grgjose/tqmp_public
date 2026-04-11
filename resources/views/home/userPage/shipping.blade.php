<!DOCTYPE html>
<html lang="en">
<head>
    @include('plus.head')
</head>
<body>
    @include('plus.navbar')
    <section>
        <div class="container shadow-sm mt-5 mb-4 border-0">
            <div class="card-body p-0">
                <div class="mb-3">
                        <label class="form-label fw-medium">Search Address</label>
                        <input
                            type="text"
                            id="addressInput"
                            class="form-control form-control-lg"
                            placeholder="Type your delivery address..."
                        >
                    </div>
                <div id="map" style="height: 600px; border-radius: 8px 8px 0 0;"></div>
                <div class="p-3 bg-light text-center">
                    <small class="text-muted"><i class="fas fa-hand-pointer text-danger me-1"></i> Click on the map to set your address</small>
                </div>
            </div>
        </div>
        <div class="container py-5">
            <div id="errorMessages" style="color: red;">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <form action="/save-shipping" method="POST" id="shippingForm">
                @csrf
                <div class="mb-4 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-danger">
                            <i class="fas fa-map-marker-alt me-2"></i>Shipping Address
                        </h5>
                        <div class="address-details mb-3">
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="fw-medium text-muted">Address:</span>
                                <span id="address" class="fw-semibold">Not selected</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <span class="fw-medium text-muted">Coordinates:</span>
                                <span>
                                    <span id="lat" class="fw-semibold badge bg-light text-dark me-1">Lat: -</span>
                                    <span id="lng" class="fw-semibold badge bg-light text-dark">Lng: -</span>
                                </span>
                            </div>
                            <div style="display: none;" id="deliveryFeeContainer">
                                <span class="fw-medium text-muted">Delivery Fee</span>
                                <span id="quote" class="fw-semibold text-danger">-</span>
                            </div>
                        </div>
                        <div id="address-confirmation" class="alert alert-success mt-3 mb-0 py-2" style="display: none;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2"></i>
                                <span>Location confirmed</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3 text-danger">
                            <i class="fas fa-user-circle me-2"></i>Contact Details
                        </h5>
                        <form class="needs-validation" novalidate>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label class="form-label fw-medium">Full Name</label>
                                    <input type="text" name="fullname" class="form-control form-control-lg" 
                                        placeholder="Juan Dela Cruz" value="{{ $my_user->fname.' '.$my_user->mname.' '.$my_user->lname }}" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-medium">Full Address</label>
                                    <input type="text" name="fulladdress" class="form-control form-control-lg" 
                                        placeholder="B2 L3 Sunshine Village, Brgy. Happy, City of Dreams, Country" value="{{ $my_user->address }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" value="{{ $my_user->email }}" class="form-control form-control-lg" placeholder="your@email.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-medium">Contact Number</label>
                                    <input type="tel" name="contact_num" id="contact_number" value="{{ $my_user->contact_num }}" class="form-control form-control-lg" placeholder="0912 345 6789" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-medium">Delivery Instructions</label>
                                    <textarea class="form-control" name="instructions" rows="2" placeholder="Gate code, landmarks, etc."></textarea>
                                    <small class="text-muted">Optional but recommended for faster delivery</small>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" name="isDefault" type="checkbox" id="save-address" checked>
                                        <label class="form-check-label" for="save-address">
                                            Set this Address as my default shipping address
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="lat" id="hidden_lat" value="">
                                <input type="hidden" name="lng" id="hidden_lng" value=""> 
                                <input type="hidden" name="delivery_fee" id="hidden_delivery_fee" value="">
                                <input type="hidden" name="address" id="hidden_address" value="">
                            </div>
                        </form>
                    </div>
                    <div class="card-footer bg-transparent border-0 p-4 pt-0">
                        <button class="btn btn-primary btn-lg w-100 py-3 fw-bold" type="submit">
                            <i class="fas fa-paper-plane me-2"></i> Confirm Shipping Address
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include ('plus.chatbot')
    @include ('plus.footer')
    @include ('plus.scripts')
</body>
</html>