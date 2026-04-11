<!DOCTYPE html>
<html lang="en">

<head>
    @include ('plus.head')
</head>

<body>
    @include('plus.navbar')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <div class="container py-5 mt-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item text-muted"><a href="/home" class="text-decoration-none text-muted">Home</a>
                </li>
                <li class="breadcrumb-item text-muted"><a href="/shop"
                        class="text-decoration-none text-muted">Products</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page" style="color: #8b0000;">Add to Cart</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-md-6">
                <div class="product-image-container mb-3">
                    @foreach ($productImages as $image)
                        @if ($image->product_id == $product->id)
                            <img src="{{ asset('storage/all-items/' . $image->filename) }}"
                                onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                alt="{{ $product->display_name }}" class="img-fluid rounded-4 shadow-sm"
                                style="width: 100%; height: 500px; object-fit: cover;">
                            @break
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="col-md-6">
                <form action="/add-to-cart/{{ $product->id }}" method="POST">
                    @csrf
                    <h2 class="fw-bold mt-2" style="color: #333;">{{ $product->display_name }}</h2>
                    <p class="text-muted fs-5 mb-3">{{ $product->name }}</p>

                    <div class="d-flex align-items-center mb-4 gap-3">
                        <span class="text-warning">★ ★ ★ ★ ★</span>
                        <span class="text-muted small">5.00 Rating (Verified)</span>
                        <span
                            class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                            <i class="bi bi-check-circle-fill me-1"></i>In Stock
                        </span>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-sm-12">
                            @if ($my_user->isDiscounted)
                                <div class="d-flex align-items-baseline gap-2">
                                    <h2 class="fw-bold mb-0" style="color: #8b0000;">
                                        ₱{{ number_format($product->discounted_price, 2) }}</h2>
                                    <span
                                        class="text-decoration-line-through text-muted">₱{{ number_format($product->price, 2) }}</span>
                                </div>
                            @elseif($my_user->isSpecialDiscounted)
                                <div class="d-flex flex-column">
                                    <div class="small d-flex flex-column line-height-sm mb-1">
                                        <span class="text-muted opacity-75">Original Price: <span
                                                class="text-decoration-line-through">₱{{ number_format($product->price, 2) }}</span></span>
                                        <span class="text-muted opacity-75">Discounted Price: <span
                                                class="text-decoration-line-through">₱{{ number_format($product->discounted_price, 2) }}</span></span>
                                    </div>
                                    <h2 class="fw-bold mb-0"
                                        style="color: #8b0000; font-size: 2.25rem; letter-spacing: -1px;">
                                        ₱{{ number_format($product->special_discounted_price, 2) }}
                                    </h2>
                                </div>
                            @else
                                <h2 class="fw-bold mb-0" style="color: #333;">₱{{ number_format($product->price, 2) }}
                                </h2>
                            @endif
                            <small class="text-muted d-block mt-1">+12% VAT Added</small>
                        </div>
                    </div>

                    <input type="hidden" name="id" value="{{ $product->id }}">
                    @php
                        $finalPrice = $product->price;
                        if ($my_user->isDiscounted) {
                            $finalPrice = $product->discounted_price;
                        } elseif ($my_user->isSpecialDiscounted) {
                            $finalPrice = $product->special_discounted_price;
                        }
                    @endphp
                    <input type="hidden" name="price" value="{{ $finalPrice }}">

                    @if ($product->brand || $product->color || $product->size || $product->thickness)
                        <div class="bg-light p-4 rounded-4 border mb-4">
                            <h6 class="fw-bold mb-3">Product Specifications</h6>
                            <div class="row g-3">
                                @if ($product->brand)
                                    <div class="col-6"><label class="small text-muted d-block">Brand</label><span
                                            class="fw-semibold">{{ $product->brand }}</span></div>
                                @endif
                                @if ($product->color)
                                    <div class="col-6"><label class="small text-muted d-block">Color</label><span
                                            class="fw-semibold">{{ $product->color }}</span></div>
                                @endif
                                @if ($product->size)
                                    <div class="col-6"><label class="small text-muted d-block">Size</label><span
                                            class="fw-semibold">{{ $product->size }}</span></div>
                                @endif
                                @if ($product->thickness)
                                    <div class="col-6"><label class="small text-muted d-block">Thickness</label><span
                                            class="fw-semibold">{{ $product->thickness }}</span></div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="d-flex align-items-center gap-2 mt-3">
                        <div class="btn-group overflow-hidden border rounded-3"
                            style="width: 140px; height: 48px; --bs-border-color: #8b0000;">
                            <button type="button" onclick="decreaseQuantity()"
                                class="btn btn-danger border-0">-</button>
                            <input type="number" id="quantity" name="quantity"
                                class="form-control text-center bg-white border-0" value="1" readonly>
                            <button type="button" onclick="increaseQuantity()"
                                class="btn btn-danger border-0 fw-bold">+</button>
                        </div>

                        <button type="submit"
                            class="btn btn-danger btn-lg w-100 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center shadow-hover"
                            style="height: 48px;">
                            Add to Cart
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Styling to make the quantity input look cleaner */
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .shadow-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
    </style>
</body>
@include ('plus.footer')
@include ('plus.scripts')
<script>
    function increaseQuantity() {
        if (parseInt($('#quantity').val()) <= 99) {
            $('#quantity').val(parseInt($('#quantity').val()) + 1)
        }
    }

    function decreaseQuantity() {
        if (parseInt($('#quantity').val()) >= 2) {
            $('#quantity').val(parseInt($('#quantity').val()) - 1)
        }
    }
    const combinations = @json($combinations);

    function getSelectedAttributes() {
        let selected = {};
        $('.variant-select').each(function() {
            const key = $(this).attr('name');
            const value = $(this).val();
            if (value) {
                selected[key] = value;
            }
        });
        return selected;
    }

    function findMatchingCombination(selected) {
        return combinations.find(combo =>
            Object.keys(selected).every(key =>
                combo.attributes[key] === selected[key]
            )
        );
    }

    function updateVariantInfo(match) {
        if (match) {
            $('#product_price').text(match.price.toFixed(2));
            $('#stock').text(match.stock + " In Stock");
        } else {}
    }

    function filterInvalidOptions() {
        const selected = getSelectedAttributes();
        const keys = Object.keys(@json($variantOptions));
        keys.forEach(function(key) {
            const $select = $('#' + key);
            const currentVal = $select.val();
            $select.find('option').each(function() {
                const optionVal = $(this).val();
                if (optionVal === '') return;
                let testSelection = {
                    ...selected,
                    [key]: optionVal
                };
                const valid = combinations.some(combo =>
                    Object.keys(testSelection).every(k =>
                        combo.attributes[k] === testSelection[k]
                    )
                );
                $(this).prop('disabled', !valid);
            });
            $select.val(currentVal);
        });
    }
    $('.variant-select').on('change', function() {
        const selected = getSelectedAttributes();
        const match = findMatchingCombination(selected);
        updateVariantInfo(match);
        filterInvalidOptions();
    });
    filterInvalidOptions();
</script>

</html>
