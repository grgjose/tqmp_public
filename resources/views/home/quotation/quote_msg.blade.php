<!DOCTYPE html>
<html lang="en">
<head>
    @include('plus.head')
</head>
<body>
    @include('plus.navbar')
    <section class="container">
        <div class="container-fluid py-4">
            <div class="row" style="margin-top: 50px;">
                <div class="mx-auto">
                    <div class="card-header bg-white py-3">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <nav aria-label="breadcrumb" class="mb-0">
                                <h6 class="mb-0">
                                    <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a class="text-danger" href="/quotes-status">Quotation Status</a></li>
                                        <li class="breadcrumb-item"><a class="text-danger" href="#">View Quotation</a></li>
                                    </ol>
                                </h6>
                            </nav>
                            <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                                {{-- <div class="dropdown">
                                    <button class="card-button btn btn-primary fade-in dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Upload <i class="fa-solid fa-caret-down ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#uploadConformeModal">
                                                Signed Conforme
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#uploadProofModal">
                                                Proof of payment
                                            </a>
                                        </li>
                                    </ul>
                                </div> --}}
                                <div class="modal fade" id="uploadProofModal" tabindex="-1" aria-labelledby="uploadProofModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="/upload-proof-of-payment/{{$quotation->id}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadProofModalLabel">Upload Proof of Payment</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" class="form-control" name="proof" accept=".pdf,.doc,.docx,.jpg,.png,.heic" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="card-button btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="card-button btn btn-success">Upload</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="uploadConformeModal" tabindex="-1" aria-labelledby="uploadConformeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="/upload-conforme-user/{{$quotation->id}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadConformeModalLabel" style="color: black;">Upload Signed Conforme</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" class="form-control" name="conforme" accept=".pdf,.doc,.docx,.jpg,.png" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="card-button btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="card-button btn btn-success">Upload</button>
                                                </div>
                                                <input type="hidden" name="toStatus" value="notToStatus">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="uploadArModal" tabindex="-1" aria-labelledby="uploadArModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form method="POST" action="/upload-ar-sp/{{$quotation->id}}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="uploadArModalLabel">Upload Receipt</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="file" class="form-control" name="ar" accept=".pdf,.doc,.docx,.jpg,.png" required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="card-button btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="card-button btn btn-success">Upload</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="dropdown">
                                    <button class="card-button btn btn-primary fade-in dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Download <i class="fa-solid fa-caret-down ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" onclick="downloadConforme({{$quotation->id}})">Quotation Document</a></li>
                                        <li><a class="dropdown-item" onclick="downloadAr({{$quotation->id}})">Acknowledgement Receipt</a></li>
                                    </ul>
                                </div> --}}
                                <div class="dropdown">
                                    <button class="card-button btn btn-primary fade-in dropdown-toggle no-caret" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Options <i class="fa-solid fa-caret-down ms-1"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($quotation->status != 'Cancelled' && $quotation->status != 'Expired' && $quotation->isAddedToCart == false)
                                        <li><a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</a></li>
                                        {{-- <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</a></li> --}}
                                        @endif

                                        @if($quotation->status != 'Approved' && $quotation->status != 'Added to Cart' && $quotation->status != 'Expired')
                                        <li><a class="dropdown-item" style="cursor: pointer;" href="#" onclick="downloadConforme({{$quotation->id}})">Download Quotation Conforme</a></li>
                                        <li><a class="dropdown-item" style="cursor: pointer;" href="#" data-bs-toggle="modal" data-bs-target="#uploadConformeModal">Upload Signed Conforme</a></li>
                                        @endif

                                        @php
                                            $isExpired = $quotation->valid_until && \Carbon\Carbon::now()->greaterThan($quotation->valid_until);
                                        @endphp
                                        @if(
                                            $quotation->status != 'Cancelled' &&
                                            $quotation->status != 'Expired' &&
                                            $quotation->isAddedToCart == false &&
                                            $quotation->isApprovedSales == true &&
                                            !$isExpired &&
                                            !($quotation->valid_until && \Carbon\Carbon::now()->greaterThan($quotation->valid_until)) &&
                                            $quotation->final_price > 0
                                        )
                                        <li><a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#addToCartModal">Add to Cart</a></li>
                                        @elseif($isExpired)
                                        <li><a class="dropdown-item disabled text-muted">Add to Cart (Expired)</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        {{-- Status Messages (Conforme-based flow) --}}
                        @if($quotation->status == 'Expired')
                            <label class="form-label fw-bold">Status:</label>
                            <span style="color: red;">
                                This quotation has <strong>expired</strong>. The valid period has elapsed and it can no longer be added to cart.
                            </span>

                        @elseif($quotation->status == 'Cancelled')
                            <label class="form-label fw-bold">Status:</label>
                            <span style="color: red;">This quotation has been cancelled.</span>

                        @elseif($quotation->filename_conforme == null || $quotation->filename_conforme == "")
                            <label class="form-label fw-bold">Next Step:</label>
                            <span style="color: red;">
                                Wait for the Sales Representative to upload the Quotation Document (Conforme). You will need to sign it and upload it back.
                            </span>

                        @elseif($quotation->filename_conforme_signed == null || $quotation->filename_conforme_signed == "")
                            <label class="form-label fw-bold">Next Step:</label>
                            <span style="color: red;">
                                The Sales Representative has uploaded your Quotation Document. Please <strong>download, sign, and upload back</strong> the Signed Conforme to continue.
                            </span>

                        @elseif($quotation->final_price == 0 || $quotation->valid_until == null)
                            <label class="form-label fw-bold">Next Step:</label>
                            <span style="color: orange;">
                                Your signed conforme has been received. Waiting for the Sales Representative to set the <strong>Final Price</strong> and <strong>Valid Until</strong> date.
                            </span>

                        @elseif($quotation->isApprovedSales == false)
                            <label class="form-label fw-bold">Next Step:</label>
                            <span style="color: orange;">
                                Waiting for the Sales Representative to review and <strong>approve</strong> the quotation.
                            </span>

                        @elseif($quotation->isApprovedUser == false && $quotation->isApprovedSales == true)
                            <label class="form-label fw-bold">Next Step:</label>
                            <span style="color: green;">
                                The Sales Representative has approved this quotation. Please <strong>review and approve</strong> it to unlock Add to Cart.
                                The final price is <strong>₱{{ number_format($quotation->final_price, 2) }}</strong> and it is valid until <strong>{{ \Carbon\Carbon::parse($quotation->valid_until)->format('F j, Y') }}</strong>.
                            </span>

                        @elseif($quotation->isApprovedUser == true && $quotation->isApprovedSales == true && $quotation->isAddedToCart == false)
                            <label class="form-label fw-bold">Next Step:</label>
                            <span style="color: green;">
                                Your quotation is fully approved! You can now <strong>Add to Cart</strong>.
                                Valid until <strong>{{ \Carbon\Carbon::parse($quotation->valid_until)->format('F j, Y') }}</strong>.
                            </span>

                        @elseif($quotation->isAddedToCart == true)
                            <label class="form-label fw-bold">Status:</label>
                            <span style="color: blue;">This quotation has been added to your cart.</span>

                        @endif
                    </div>
                    <div class="row mt-3">
                        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="/cancel-quotation">
                                        @csrf
                                        <input type="hidden" name="quotation_id" value="{{ $quotation->id }}" />
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color: black;" id="cancelModalLabel">Confirm Cancellation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to cancel? Which means this Quotation will no longer be available for Update / Messages?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="card-button btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="card-button btn btn-primary" data-bs-dismiss="modal">Yes, Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="/approve-quotation">
                                        @csrf
                                        <input type="hidden" name="quotation_id" value="{{ $quotation->id }}" />
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="approveModalLabel">Confirm Approval</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to Approve? All Details in this Quotation will be valid and unchangeable in 2 weeks or more, making this Quotaiton uneditable.
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="card-button btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="card-button btn btn-success" data-bs-dismiss="modal">Yes, Approve</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form method="POST" action="/quotation-to-cart">
                                        @csrf
                                        <input type="hidden" name="quotation_id" value="{{ $quotation->id }}" />
                                        <div class="modal-header">
                                            <h5 class="modal-title" style="color: black;" id="addToCartModalLabel">Confirm Add to Cart</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to add this item to your cart?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="card-button btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="card-button btn btn-primary" data-bs-dismiss="modal">Yes, Add to Cart</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-9" data-bs-spy="scroll" data-bs-target="#quotationScrollspy" data-bs-offset="100" style="height: 600px; width:auto; overflow-y: auto;">
                                        <div id="details" class="mb-5">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Service Type</label>
                                                @if($quotation->quotation_type == 'glass')
                                                <input name="glasstype[]" class="form-control" type="text" placeholder="Glass Processing" readonly>
                                                @else
                                                <input name="glasstype[]" class="form-control" type="text" placeholder="Bullet Proofing" readonly>
                                                @endif
                                                <input type="hidden" name="quotation_type" value="glass">
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Status</label>
                                                    <input class="form-control" type="text" placeholder="{{ $quotation->status }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Valid Until</label>
                                                    @if($quotation->valid_until == null)
                                                    <input class="form-control" type="text" placeholder="TBD" readonly>
                                                    @else
                                                    <input class="form-control" type="text" placeholder="{{ $quotation->valid_until }}" readonly>
                                                    @endif
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold" style="color: red;">Final Price</label>
                                                    @if($quotation->final_price == 0)
                                                    <input class="form-control" type="text" placeholder="TBD" readonly>
                                                    @else
                                                    <input class="form-control" type="text" placeholder="{{ $quotation->final_price }}" readonly>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($quotation->quotation_type == 'bullet')
                                            @php
                                            $services = [
                                            'armoured' => 'Armoured Car',
                                            'radiator' => 'Radiator Grill',
                                            'gasTank' => 'Gas Tank Cover',
                                            'suspension' => 'Upgraded Suspension',
                                            'battery' => 'Battery & Fuse Box Cover',
                                            'runFlat' => 'Run Flat Insert',
                                            'partition' => 'Back Door Partition',
                                            'catcher' => 'Bullet Catcher',
                                            'seats' => 'Premium Leather Seats',
                                            ];
                                            $selectedServices = json_decode(str_replace("'", '"', $quotation->services), true);
                                            @endphp
                                            <div class="row g-3 mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Plate Number</label>
                                                    <input class="form-control" type="text" placeholder="{{ $quotation->plate_number }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Model</label>
                                                    <input class="form-control" type="text" placeholder="{{ strtoupper($quotation->model) }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label fw-bold">Color</label>
                                                    <input class="form-control" type="text" placeholder="{{ ucfirst($quotation->unit_color) }}" readonly>
                                                </div>
                                            </div>
                                            <div class="row g-3 mb-3">
                                                <label class="form-label fw-bold">Selected Services</label>
                                                @foreach ($services as $value => $label)
                                                <div class="col-md-4">
                                                    <div class="form-check">
                                                        <input
                                                            class="form-check-input"
                                                            type="checkbox"
                                                            disabled
                                                            {{ in_array($value, $selectedServices) ? 'checked' : '' }}>
                                                        <label class="form-check-label">{{ $label }}</label>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @if($quotation->remarks != null)
                                            <div class="row g-3 mb-2">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold">Remarks</label>
                                                    <input class="form-control" type="text" placeholder="{{ $quotation->remarks }}" readonly>
                                                </div>
                                            </div>
                                            @endif
                                            @endif
                                            @if($quotation->quotation_type == 'glass')
                                                                                        <div class="row g-3 mb-3">
                                                <div class="col-md-12">
                                                    <button class="card-button btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#itemsModal">View Items</button>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="itemsModal" tabindex="-1" aria-labelledby="itemsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-xl">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="itemsModalLabel">List of Items</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @php
                                                            $types = json_decode(str_replace("'", '"', $quotation->type), true);
                                                            $thicknesses = json_decode(str_replace("'", '"', $quotation->thickness), true);
                                                            $h1s = json_decode(str_replace("'", '"', $quotation->h1), true);
                                                            $h2s = json_decode(str_replace("'", '"', $quotation->h2), true);
                                                            $w1s = json_decode(str_replace("'", '"', $quotation->w1), true);
                                                            $w2s = json_decode(str_replace("'", '"', $quotation->w2), true);
                                                            $quantities = json_decode(str_replace("'", '"', $quotation->quantity), true);
                                                            $colors = json_decode(str_replace("'", '"', $quotation->color), true);
                                                            $cuttings = json_decode(str_replace("'", '"', $quotation->cutting_details), true);
                                                            @endphp
                                                            <div id="item-rows-container">
                                                                @for($i = 0; $i < count($types); $i++)
                                                                    <div class="row mb-3 item-row" data-row="1">
                                                                    <div class="col-md-3">
                                                                        <label class="form-label text-muted">Glass Type <span class="text-danger">*</span></label>
                                                                        @foreach($products as $product)
                                                                        @if($product->id == $types[$i])
                                                                        <input name="height1[]" class="form-control form-control-sm" type="text" placeholder="{{ $product->display_name }}" readonly>
                                                                        @endif
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label class="form-label text-muted">Thickness <span class="text-danger">*</span></label>
                                                                        <input name="height1[]" class="form-control form-control-sm" type="text" placeholder="{{ $thicknesses[$i] }}" readonly>
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label class="form-label text-muted">Color <span class="text-danger">*</span></label>
                                                                        <input name="height1[]" class="form-control form-control-sm" type="text" placeholder="{{ $colors[$i] }}" readonly>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label class="form-label text-muted">H1 <span class="text-danger">*</span></label>
                                                                        <input name="height1[]" class="form-control form-control-sm" type="number" placeholder="{{ $h1s[$i] }}" readonly>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label class="form-label text-muted">H2 <span class="text-danger">*</span></label>
                                                                        <input name="height2[]" class="form-control form-control-sm" type="number" placeholder="{{ $h2s[$i] }}" readonly>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label class="form-label text-muted">W1 <span class="text-danger">*</span></label>
                                                                        <input name="width1[]" class="form-control form-control-sm" type="number" placeholder="{{ $w1s[$i] }}" readonly>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label class="form-label text-muted">W2 <span class="text-danger">*</span></label>
                                                                        <input name="width2[]" class="form-control form-control-sm" type="number" placeholder="{{ $w2s[$i] }}" readonly>
                                                                    </div>
                                                                    <div class="col-md-1">
                                                                        <label class="form-label text-muted">Qty <span class="text-danger">*</span></label>
                                                                        <input name="quantity[]" class="form-control form-control-sm" type="number" min="1" value="{{ $quantities[$i] }}" readonly>
                                                                    </div>
                                                                    <div class="mt-3">
                                                                        <label for="remarks" class="form-label text-muted">Cutting Details<span class="text-danger">*</span></label>
                                                                        <textarea id="remarks" name="cutting_details" rows="3" placeholder="{{ $cuttings[$i] }}"
                                                                            class="form-control form-control-sm" readonly>{{ $cuttings[$i] }}</textarea>
                                                                    </div>
                                                                    <div class="col-md-12 mt-2 text-end">
                                                                        <button type="button" class="btn btn-sm btn-primary remove-row-btn" style="display: none;">Remove Row</button>
                                                                    </div>
                                                            </div>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="card-button btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div id="imagesGallery" class="mb-3">
                                        <label class="form-label fw-bold">Images Gallery</label>
                                        <div class="border rounded p-2">
                                            @if(isset($quotationImages) && count($quotationImages) > 0)
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach($quotationImages as $image)
                                                <div class="border rounded overflow-hidden position-relative" style="width: 100px; height: 100px;"
                                                    data-bs-toggle="modal" data-bs-target="#imageModal"
                                                    onclick="openImageModal('{{ asset('storage/quotations/'.$image->filename) }}', '{{ $image->filename }}')">
                                                    <img src="{{ asset('storage/quotations/'.$image->filename) }}"
                                                        alt="{{ $image->filename }}"
                                                        class="w-100 h-100 object-fit-cover"
                                                        style="transition: transform 0.3s;">
                                                    <div class="position-absolute top-0 start-0 w-100 h-100 hover-overlay"></div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <div class="text-center py-2 text-muted">
                                                No images available
                                            </div>
                                            @endif
                                        </div>
                                        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="imageModalLabel">Image View</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center p-0">
                                                        <div id="zoomContainer" style="overflow: hidden;">
                                                            <img id="modalImage" src=""
                                                                class="img-fluid"
                                                                style="max-width: 100%; max-height: 80vh; cursor: zoom-in;"
                                                                onclick="toggleZoom(this)">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="card-button btn btn-primary" onclick="navigateImage(-1)">Previous</button>
                                                        <span id="imageCounter"></span>
                                                        <button type="button" class="card-button btn btn-primary" onclick="navigateImage(1)">Next</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <style>
                                        .hover-overlay {
                                            background-color: rgba(0, 0, 0, 0.2);
                                            opacity: 0;
                                            transition: opacity 0.3s;
                                        }
                                        .overflow-hidden:hover .hover-overlay {
                                            opacity: 1;
                                        }
                                        #zoomContainer {
                                            transition: transform 0.3s;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="messages">
                            <div class="card-body p-0" style="position: relative; height: 450px; overflow-y: auto;" data-bs-spy="scroll" data-bs-target="#notes-nav" data-bs-offset="20">
                                <div id="note-0" class="border-end border-secondary border-4 mb-3 bg-white p-3">
                                    <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">TQ</div>
                                            <div class="ms-2">
                                                <strong>Default</strong>
                                                <div class="text-muted small">{{ $quotation->created_at }}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-secondary me-1">Default Message</span>
                                            <span><i class="fas fa-ellipsis-v"></i></span>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="mb-0">[Internal Note] Please wait for the Sales Representative's Verification. The Representative will message here in a bit. It is possible that the Representative will call you on your designated number for clarification.</p>
                                    </div>
                                </div>
                                @foreach($quotationMessages as $message)
                                @if($message->usertype == 3)
                                <div id="note-{{$message->id}}" class="border-start border-primary border-4 mb-3 bg-white p-3">
                                    <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                {{ strtoupper(substr($message->fname, 0, 1) . substr($message->lname, 0, 1)) }}
                                            </div>
                                            <div class="ms-2">
                                                <strong>{{ $message->fname.' '.$message->lname }}</strong>
                                                <div class="text-muted small">{{ $message->created_at }}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-primary me-1">Customer</span>
                                            <span><i class="fas fa-ellipsis-v"></i></span>
                                        </div>
                                    </div>
                                    <div>
                                        {!! $message->message !!}
                                    </div>
                                </div>
                                @else
                                <div id="note-2" class="border-end border-danger border-4 mb-3 bg-white p-3">
                                    <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 border-bottom">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">SR</div>
                                            <div class="ms-2">
                                                <strong>{{ $message->fname.' '.$message->lname }}</strong>
                                                <div class="text-muted small">{{ $message->created_at }}</div>
                                            </div>
                                        </div>
                                        <div>
                                            <span class="badge bg-danger me-1">Sales Representative</span>
                                            <span><i class="fas fa-ellipsis-v"></i></span>
                                        </div>
                                    </div>
                                    <div>
                                        {!! $message->message !!}
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @if($quotation->status != 'Cancelled' && $quotation->status != 'Approved')
                        <div class="card-footer p-0 mt-3">
                            <form action="/user-send-message" method="POST">
                                @csrf
                                <input type="hidden" name="quotation_id" value="{{ $quotation->id }}">
                                <textarea id="summernote" name="message"></textarea>
                                <div class="p-3 bg-light d-flex justify-content-between">
                                    <div>
                                    </div>
                                    <div>
                                        <button type="submit" class="card-button btn btn-primary fade-in">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    @include('plus.scripts')
    @include('plus.footer')
</body>
</html>