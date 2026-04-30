<!DOCTYPE html>
<html lang="en">
<head>
    @include('plus.head')
</head>
<body>
    @include('plus.navbar')
    <div class="container py-5 mt-5">
        <div class="container fade-in-up">
            <h3 class="fw-bold">Quotation Status</h3>
            <div class="p-3 my-5 bg-light border-border-primary shadow-sm rounded">
                <table class="table table-striped nowrap" id="quotationsTable">
                    <thead>
                        <tr>
                            <th>Quotation ID</th>
                            <th></th>
                            <th>Status</th>
                            <th>Next Action</th>
                            <th>Total Pricing</th>
                            <th>Valid Until</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($quotations) == 0)
                        <tr>
                            <td colspan="4" class="text-center py-3">No available data</td>
                        </tr>
                        @else
                        @foreach($quotations as $quote)
                        <tr>
                            <td>
                                <a href="/show-quotation/{{ $quote->reference }}" class="quotation-link"
                                    data-reference="{{ $quote->reference }}">
                                    {{ $quote->reference }}
                                </a>
                            </td>
                            <td>
                                @if($quote->status != 'Cancelled')
                                <a href="/show-quotation/{{ $quote->reference }}" class="btn btn-sm btn-outline-primary ms-2 ml-2"
                                    data-reference="{{ $quote->reference }}">
                                    Message Agent
                                    <span class="fa-solid fa-message ms-1"></span>
                                </a>
                                @endif
                            </td>
                            <td>
                                @php
                                    $quotExpired = $quote->valid_until && \Carbon\Carbon::now()->greaterThan($quote->valid_until) && !in_array($quote->status, ['Cancelled', 'Expired']);
                                @endphp

                                @if($quotExpired)
                                    <span class="badge bg-danger">Expired</span>
                                @else
                                    {{ $quote->status }}
                                @endif
                            </td>
                            <td>
                                @if($quote->status != 'Cancelled')
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="downloadUploadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="downloadUploadDropdown">
                                        @if($quote->status != 'Cancelled' && $quote->status != 'Expired' && $quote->isAddedToCart == false)
                                        <li><a class="dropdown-item" style="cursor: pointer;" onclick="$('#quotation_id_modal').val({{ $quote->id }});" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel</a></li>
                                        {{-- <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approveModal">Approve</a></li> --}}
                                        @endif
                                        @if(!$quote->isApprovedSales)
                                        <li><a class="dropdown-item" href="#" onclick="downloadConforme({{$quote->id}}, 'somehwere')">Download Quotation</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="uploadConforme({{$quote->id}})" data-bs-toggle="modal" data-bs-target="#uploadConformeModal">Upload Signed Conforme</a></li>
                                        @endif
                                        {{-- <li><a class="dropdown-item" href="#" onclick="uploadProof({{$quote->id}})" data-bs-toggle="modal" data-bs-target="#uploadProofModal">Upload Proof of Payment</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="downloadAr({{$quote->id}}, 'somehwere')">Download Acknowledgement Receipt</a></li> --}}
                                        @if(
                                            $quote->isApprovedSales &&
                                            !$quote->isAddedToCart &&
                                            $quote->status !== 'Cancelled' &&
                                            $quote->status !== 'Expired' &&
                                            !($quote->valid_until && \Carbon\Carbon::now()->greaterThan($quote->valid_until)) &&
                                            $quote->final_price > 0
                                        )
                                            <li><a class="dropdown-item" href="#" onclick="AddtoCartUpdateModal({{$quote->id}})" 
                                                   data-bs-toggle="modal" data-bs-target="#addToCartModal">Add to Cart</a></li>
                                        @endif
                                    </ul>
                                </div>
                                @endif
                            </td>
                            <td>{{ $quote->final_price }}</td>
                            <td>{{ $quote->valid_until }}</td>
                            <td>{{ $quote->remarks }}</td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="uploadProofModal" tabindex="-1" aria-labelledby="uploadProofModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" id="uploadProofForm" action="/upload-proof-of-payment/" enctype="multipart/form-data">
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
                        <input type="hidden" name="toStatus" value="toStatus">
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="uploadConformeModal" tabindex="-1" aria-labelledby="uploadConformeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" id="uploadConformeForm" action="/upload-conforme-user/" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadConformeModalLabel">Upload Signed Conforme</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="file" class="form-control" name="conforme" accept=".pdf,.doc,.docx,.jpg,.png" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="card-button btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="card-button btn btn-success">Upload</button>
                        </div>
                        <input type="hidden" name="toStatus" value="toStatus">
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addToCartModal" tabindex="-1" aria-labelledby="addToCartModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="/quotation-to-cart">
                        @csrf
                        <input type="hidden" id="quotation_id_modal" name="quotation_id" value="" />
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
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="/cancel-quotation">
                        @csrf
                        <input type="hidden" id="quotation_id_modal" name="quotation_id" value="" />
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
    </div>
    <script>
        function AddtoCartUpdateModal(id) {
            $("#quotation_id_modal").val(id);
        }
        let table = new DataTable('#quotationsTable', {
            lengthChange: false,
            responsive: true
        });
    </script>
    @include('plus.scripts');
    @include ('plus.chatbot')
    @include ('plus.footer')
</body>
</html>