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
                <h4 class="card-title">List of Quotations</h4>
            </div>
            <div class="card-body">
                <table id="tbl_quotations" class="table is-striped" style="width:100%; text-align: left;">
                    <thead>
                        <tr>
                            <th style="width: 15%">Reference</th>
                            <th style="width: 20%">Type</th>
                            <th style="width: 20%">Customer Name</th>
                            <th style="width: 15%">Status</th>
                            <th style="width: 15%">Download/Upload</th>
                            <th style="width: 30%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotations as $quotation)
                        <tr>
                            <td>{{ $quotation->reference }}</td>
                            <td>{{ ucfirst($quotation->quotation_type) == "Bullet" ? "Bullet Proofing" : "Glass Processing" }}</td>
                            <td>
                                @foreach($users as $user)
                                @if($user->id == $quotation->user_id)
                                {{ $user->fname.' '.$user->mname.' '.$user->lname }}
                                @continue
                                @endif
                                @endforeach
                            </td>
                            <td>
                                <div class="btn-group-sm">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="statusButton{{$quotation->id}}">
                                        {{ $quotation->status }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if($quotation->quotation_type == 'glass')
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Pending</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">In Progress</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Approved</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">For Cutting</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">For Edging</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">For Drilling</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">For Frosting</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">For Laminating</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">For Curve</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">For IGU</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">For Tempering</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Ready to Pickup</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Ready to Deliver</a></li>
                                        @else
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Waiting for vehicle</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Dismantling vehicle parts</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Upgrading vehicle parts</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Finalizing upgrades</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Upgrade complete</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="changeStatus({{$quotation->id}}, this.innerText)">Ready for vehicle pickup</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="downloadUploadDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="downloadUploadDropdown">
                                        <li><a class="dropdown-item" href="#" onclick="uploadConforme({{$quotation->id}})" data-bs-toggle="modal" data-bs-target="#uploadConformeModal">Upload Quotation</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="downloadConforme({{$quotation->id}})">Download Signed Quotation</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="downloadProof({{$quotation->id}})">Download Proof of Payment</a></li>
                                        <li><a class="dropdown-item" href="#" onclick="uploadAr({{$quotation->id}})" data-bs-toggle="modal" data-bs-target="#uploadArModal">Upload Acknowledgement Receipt</a></li>  
                                        {{-- <li><a class="dropdown-item" href="#" onclick="downloadAr({{$quotation->id}})">Download Signed Acknowledgement Receipt</a></li> --}}
                                    </ul>
                                </div>
                            </td>
                            <td>
                                <div class="btn-group-sm">
                                    <button class="btn btn-warning btn-sm" onclick="quotationShow({{ $quotation->id }})"> <i class="fa-solid fa-eye"></i> View</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="view">
        </div>
    </div>
    <div class="modal fade" id="uploadConformeModal" tabindex="-1" aria-labelledby="uploadConformeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="" method="POST" enctype="multipart/form-data" id="uploadConformeForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadConformeModalLabel">Upload Conforme</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="conforme" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="uploadArModal" tabindex="-1" aria-labelledby="uploadArModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="" method="POST" enctype="multipart/form-data" id="uploadArForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadArModalLabel">Upload Acknowledgement Receipt</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="file" name="ar" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title border-0 text-white" id="modalLabel">Reject User Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectForm" action="/approvals-reject/" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="reason">Reason</label>
                                <textarea cols="10" rows="5" class="form-control" style="resize: none;" id="reason" name="reason"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Reject</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<form action="" method="POST" style="display: none;" id="changeStatusForm">
    @csrf
    <input type="hidden" name="status" id="changeStatusInput">
</form>
<script>
    function changeStatus(id, status) {
        $('#changeStatusForm').attr('action', '/quotation-status-change/' + id);
        $('#changeStatusInput').val(status);
        $('#changeStatusForm').submit();
        $('#statusButton').html(status);
    }

    function downloadConforme(id) {
        window.location.href = '/download-conforme-sp/' + id;
    }

    function downloadAr(id) {
        window.location.href = '/download-ar-sp/' + id;
    }

    function downloadProof(id) {
        window.location.href = '/download-proof-of-payment/' + id;
    }

    function uploadConforme(id) {
        $('#uploadConformeForm').attr('action', '/upload-conforme-sp/' + id);
    }

    function uploadAr(id) {
        $('#uploadArForm').attr('action', '/upload-ar-sp/' + id);
    }
</script>