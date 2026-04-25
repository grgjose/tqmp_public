<main class="app-main px-4">
    <div class="app-content-header">
        <div class="container-fluid py-3 bg-white">
            <div class="row">
                <div class="mx-auto">
                    {{-- ─────────────────────────────────────────────────────────── --}}
                    {{-- TOOLBAR (replaces the old app-content-header + first d-flex) --}}
                    {{-- ─────────────────────────────────────────────────────────── --}}
                    <div class="qv-toolbar">
                    
                        {{-- Left: title + reference badge --}}
                        <h3 class="qv-title">
                            <i class="fa-solid fa-file-invoice" style="color:#4f60c8; font-size:.95rem;"></i>
                            Quotation Details
                            <span class="badge-ref">{{ $quotation->reference }}</span>
                        </h3>
                    
                        {{-- Right: all action buttons --}}
                        <div class="qv-btn-group">
                    
                            {{-- ── Go Back ──────────────────────────────────────── --}}
                            <button type="button"
                                    class="qv-btn qv-btn-back"
                                    onclick="quotationHide()">
                                <i class="fa-solid fa-arrow-left"></i> Go Back
                            </button>
                    
                            <div class="qv-divider"></div>
                    
                            {{-- ── File actions: Download / Upload ─────────────── --}}
                            <button type="button"
                                    class="qv-btn qv-btn-outline"
                                    onclick="downloadProof({{ $quotation->id }})">
                                <i class="fa-solid fa-receipt"></i> Proof of Payment
                            </button>
                    
                            <button type="button"
                                    class="qv-btn qv-btn-outline"
                                    onclick="downloadConforme({{ $quotation->id }})">
                                <i class="fa-solid fa-file-arrow-down"></i> Signed Conforme
                            </button>
                    
                            <button type="button"
                                    class="qv-btn qv-btn-outline"
                                    onclick="uploadConforme({{ $quotation->id }})"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadConformeModal">
                                <i class="fa-solid fa-file-arrow-up"></i> Upload Quotation
                            </button>
                    
                            <button type="button"
                                    class="qv-btn qv-btn-outline"
                                    onclick="uploadAr({{ $quotation->id }})"
                                    data-bs-toggle="modal"
                                    data-bs-target="#uploadArModal">
                                <i class="fa-solid fa-file-circle-plus"></i> Upload AR
                            </button>
                    
                            {{-- ── Approval actions (only shown when not yet approved) ── --}}
                            @if($quotation->isApprovedSales == false)
                                <div class="qv-divider"></div>
                    
                                <button type="button"
                                        class="qv-btn qv-btn-approve"
                                        onclick="showInputBox('Approved', {{ $quotation->id }})">
                                    <i class="fa-solid fa-circle-check"></i> Approve
                                </button>
                    
                                <button type="button"
                                        class="qv-btn qv-btn-reject"
                                        onclick="showInputBox('Rejected', {{ $quotation->id }})">
                                    <i class="fa-solid fa-circle-xmark"></i> Reject
                                </button>
                            @endif
                    
                        </div>{{-- /.qv-btn-group --}}
                    
                    </div>{{-- /.qv-toolbar --}}
                    <div class="row mt-2 mb-2">
                        <div class="border col-md-4">
                            <div class="row">
                                <div class="col-md-9" data-bs-spy="scroll" data-bs-target="#quotationScrollspy" data-bs-offset="100" style="height: 650px; width:auto; overflow-y: auto;">
                                    <div id="basic-info" class="mt-3 mb-3 pt-3">
                                        <h5 class="border-bottom fw-bold pb-2">Basic Information</h5>
                                        <div class="row g-2">
                                            <div class="col-md-12">
                                                <div class="row g-2">
                                                    <div class="col-md-12">
                                                        <label class="form-label small">Quotation ID</label>
                                                        <input type="text" class="form-control form-control-sm" value="{{ $quotation->reference }}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label small">Created Date</label>
                                                <input type="datetime-local" class="form-control form-control-sm" value="{{ $quotation->created_at }}" readonly>
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label small">Last Updated</label>
                                                <input type="datetime-local" class="form-control form-control-sm" value="{{ $quotation->updated_at }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="details" class="mb-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Service Type</label>
                                            @if($quotation->quotation_type == 'glass')
                                            <input name="glasstype[]" class="form-control-sm form-control" type="text" placeholder="Glass Processing" value="Glass Processing" readonly>
                                            @else
                                            <input name="glasstype[]" class="form-control-sm form-control" type="text" placeholder="Bullet Proofing" value="Bullet Proofing" readonly>
                                            @endif
                                            <input type="hidden" name="quotation_type" value="glass">
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label small">Status</label>
                                                <select class="form-select form-select-sm" name="status" id="statusField">
                                                    @if($quotation->status == null || $quotation->status == "")
                                                    <option value="" selected disabled>Select Status</option>
                                                    @endif
                                                    @if($quotation->quotation_type == 'glass')
                                                    <option value="Pending" {{ $quotation->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="In Progress" {{ $quotation->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="Approved" {{ $quotation->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                    <option value="For Cutting" {{ $quotation->status == 'For Cutting' ? 'selected' : '' }}>For Cutting</option>
                                                    <option value="For Edging" {{ $quotation->status == 'For Edging' ? 'selected' : '' }}>For Edging</option>
                                                    <option value="For Drilling" {{ $quotation->status == 'For Drilling' ? 'selected' : '' }}>For Drilling</option>
                                                    <option value="For Frosting" {{ $quotation->status == 'For Frosting' ? 'selected' : '' }}>For Frosting</option>
                                                    <option value="For Laminating" {{ $quotation->status == 'For Laminating' ? 'selected' : '' }}>For Laminating</option>
                                                    <option value="For Curve" {{ $quotation->status == 'For Curve' ? 'selected' : '' }}>For Curve</option>
                                                    <option value="For IGU" {{ $quotation->status == 'For IGU' ? 'selected' : '' }}>For IGU</option>
                                                    <option value="For Tempering" {{ $quotation->status == 'For Tempering' ? 'selected' : '' }}>For Tempering</option>
                                                    <option value="Ready to Pick Up" {{ $quotation->status == 'Ready to Pick Up' ? 'selected' : '' }}>Ready to Pick Up</option>
                                                    <option value="Ready to Deliver" {{ $quotation->status == 'Ready to Deliver' ? 'selected' : '' }}>Ready to Deliver</option>
                                                    <hr>
                                                    @else
                                                    <option value="Waiting for vehicle" {{ $quotation->status == 'Waiting for vehicle' ? 'selected' : '' }}>Waiting for vehicle</option>
                                                    <option value="Dismantling vehicle parts" {{ $quotation->status == 'Dismantling vehicle parts' ? 'selected' : '' }}>Dismantling vehicle parts</option>
                                                    <option value="Upgrading vehicle parts" {{ $quotation->status == 'Upgrading vehicle parts' ? 'selected' : '' }}>Upgrading vehicle parts</option>
                                                    <option value="Finalizing upgrades" {{ $quotation->status == 'Finalizing upgrades' ? 'selected' : '' }}>Finalizing upgrades</option>
                                                    <option value="Upgrade complete" {{ $quotation->status == 'Upgrade complete' ? 'selected' : '' }}>Upgrade complete</option>
                                                    <option value="Ready for vehicle pickup" {{ $quotation->status == 'Ready for vehicle pickup' ? 'selected' : '' }}>Ready for vehicle pickup</option>
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Valid Until</label>
                                                @if($quotation->valid_until == null)
                                                <input class="form-control-sm form-control" id="valid_until" type="date" placeholder="TBD">
                                                @else
                                                <input class="form-control-sm form-control" id="valid_until" type="date" placeholder="{{ $quotation->valid_until }}">
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" style="color: red;">Final Price</label>
                                                @if($quotation->final_price == 0)
                                                <input class="form-control-sm form-control" id="final_price" type="number" placeholder="TBD">
                                                @else
                                                <input class="form-control-sm form-control" id="final_price" type="number" placeholder="{{ $quotation->final_price }}">
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
                                                <input class="form-control-sm form-control" type="text" placeholder="{{ $quotation->plate_number }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Model</label>
                                                <input class="form-control-sm form-control" type="text" placeholder="{{ strtoupper($quotation->model) }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Color</label>
                                                <input class="form-control-sm form-control" type="text" placeholder="{{ ucfirst($quotation->unit_color) }}">
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
                                                        {{ in_array($value, $selectedServices) ? 'checked' : '' }}>
                                                    <label class="form-check-label">{{ $label }}</label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                        <div class="row g-3 mb-3">
                                            <div class="col-12">
                                                <label class="form-label fw-bold">Remarks</label>
                                                <input class="form-control-sm form-control" type="text" placeholder="{{ $quotation->remarks }}">
                                            </div>
                                        </div>
                                        @endif
                                        @if($quotation->quotation_type == 'glass')
                                                                                <div class="row g-3 mb-3">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#itemsModal">View Items</button>
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
                                                                    <input name="height1[]" class="form-control form-control-sm" type="text" placeholder="{{ $product->display_name }}">
                                                                    @endif
                                                                    @endforeach
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label class="form-label text-muted">Thickness <span class="text-danger">*</span></label>
                                                                    <input name="height1[]" class="form-control form-control-sm" type="text" placeholder="{{ $thicknesses[$i] }}">
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label class="form-label text-muted">Color <span class="text-danger">*</span></label>
                                                                    <input name="height1[]" class="form-control form-control-sm" type="text" placeholder="{{ $colors[$i] }}">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label text-muted">H1 <span class="text-danger">*</span></label>
                                                                    <input name="height1[]" class="form-control form-control-sm" type="number" placeholder="{{ $h1s[$i] }}">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label text-muted">H2 <span class="text-danger">*</span></label>
                                                                    <input name="height2[]" class="form-control form-control-sm" type="number" placeholder="{{ $h2s[$i] }}">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label text-muted">W1 <span class="text-danger">*</span></label>
                                                                    <input name="width1[]" class="form-control form-control-sm" type="number" placeholder="{{ $w1s[$i] }}">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label text-muted">W2 <span class="text-danger">*</span></label>
                                                                    <input name="width2[]" class="form-control form-control-sm" type="number" placeholder="{{ $w2s[$i] }}">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <label class="form-label text-muted">Qty <span class="text-danger">*</span></label>
                                                                    <input name="quantity[]" class="form-control form-control-sm" type="number" min="1" value="{{ $quantities[$i] }}">
                                                                </div>
                                                                <div class="mt-3">
                                                                    <label for="remarks" class="form-label text-muted">Cutting Details<span class="text-danger">*</span></label>
                                                                    <textarea id="remarks" name="cutting_details" rows="3" placeholder="{{ $cuttings[$i] }}"
                                                                        class="form-control form-control-sm">{{ $cuttings[$i] }}</textarea>
                                                                </div>
                                                                <div class="col-md-12 mt-2 text-end">
                                                                    <button type="button" class="btn btn-sm btn-primary remove-row-btn" style="display: none;">Remove Row</button>
                                                                </div>
                                                        </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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
                                                        loading="lazy"
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
                                                        <button type="button" class="btn btn-outline-primary" onclick="navigateImage(-1)">Previous</button>
                                                        <span id="imageCounter"></span>
                                                        <button type="button" class="btn btn-outline-primary" onclick="navigateImage(1)">Next</button>
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
                                    <div id="actions" class="">
                                        <div id="inputBoxContainer" class="mt-3 mb-3" style="display: none;">
                                            <form id="inputBoxForm" method="POST">
                                                @csrf
                                                <label id="inputBoxLabel" class="form-label fw-bold small"></label>
                                                <input type="hidden" name="quotation_id" value="{{ $quotation->id }}" />
                                                <input type="hidden" id="inputBoxStatus" name="status" value="" />
                                                <textarea id="inputBox" class="form-control form-control-sm" rows="2" placeholder="Enter your input here..."></textarea>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border col-md-8">
                        <div class="card-body p-0" style="position: relative; height: 450px; overflow-y: auto;" data-bs-spy="scroll" data-bs-target="#scrollspy-nav" data-bs-offset="20">
                            <div id="note-0" class="border-end border-secondary border-4 mb-3 bg-white p-3">
                                <div class="d-flex justify-content-between align-items-center bg-light p-2 mb-2 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">TQ</div>
                                        <div class="ms-2">
                                            <strong>Default</strong>
                                            <div class="text-muted small"></div>
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
                            <div id="note-1" class="border-start border-primary border-4 mb-3 bg-white p-3">
                                <div class="d-flex justify-content-between align-items-center bg-primary bg-opacity-10 p-2 mb-2 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">{{ strtoupper(substr($message->fname, 0, 1).substr($message->lname, 0, 1)) }}</div>
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
                            <div id="note-1" class="border-end border-danger border-4 mb-3 bg-white p-3">
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
                        <div class="card-footer p-0">
                            <form action="/send-message" method="POST">
                                @csrf
                                <input type="hidden" value="{{ $quotation->id }}" name="quotation_id">
                                <textarea id="summernote" name="message"></textarea>
                                <div class="p-3 bg-light text-end">
                                    <div>
                                        <button class="btn btn-sm btn-primary text-end">Send Message</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
</main>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: 'Add a message...',
            tabsize: 2,
            height: 70,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture']],
                ['view', ['codeview', 'help']]
            ],
            callbacks: {
                onInit: function() {
                    const toolbar = $('.note-toolbar');
                    const switchHtml = `
                    <div class="private-note-switch d-flex align-items-center me-2 mt-2 mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="privateNote">
                            <label class="form-check-label ms-2" for="privateNote">Private Note</label>
                        </div>
                    </div>
                `;
                    toolbar.append(switchHtml);
                    updateNoteBorder();
                    $('#privateNote').change(function() {
                        updateNoteBorder();
                    });
                    function updateNoteBorder() {
                        const editor = $('#summernote');
                        if ($('#privateNote').is(':checked')) {
                            editor.next('.note-editor').css('border-left', '4px solid #dc3545');
                        } else {
                            editor.next('.note-editor').css('border-right', '4px solid #0d6efd');
                        }
                    }
                }
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#statusField').on('change', function() {
            let newStatus = $(this).val();
            let quotationId = "{{ $quotation->id }}";
            $.ajax({
                url: '{{ route("quotation.updateStatus") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quotation_id: quotationId,
                    status: newStatus
                },
                success: function(response) {
                    console.log('Status updated successfully:', response);
                },
                error: function(xhr) {
                    console.error('Error updating status:', xhr.responseText);
                    alert('Failed to update status.');
                }
            });
        });
    });
</script>