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
            <div class="card-header">
                <h4 class="card-title">Inquirires</h4>
            </div>
            <div class="card-body">
                <table id="tbl_inquiries" class="table is-striped" style="width:100%; text-align: left;">
                    <thead>
                        <tr>
                            <th style="width: 15%">Inquiry ID</th>
                            <th style="width: 15%">Fullname</th>
                            <th style="width: 10%">Email</th>
                            <th style="width: 10%">Contact #</th>
                            <th style="width: 20%">Subject</th>
                            <th style="width: 50%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inquiries as $inquiry)
                        <tr>
                            <td>{{ $inquiry->id }}</td>
                            <td>{{ $inquiry->fullname }}</td>
                            <td>{{ $inquiry->email }}</td>
                            <td>{{ $inquiry->contact_num }}</td>
                            <td>{{ $inquiry->subject }}</td>
                            <td>
                                <div class="btn-group-sm">
                                    <button class="btn btn-warning btn-sm" onclick="showDetails({{ $inquiry->id }})"> <i class="fa-solid fa-eye"></i> View</button>
                                    <button class="btn btn-info btn-sm" onclick="downloadFile({{ $inquiry->id }})"> <i class="fa-solid fa-file-arrow-down"></i> Download File</button>
                                    <button class="btn btn-success btn-sm" onclick="approve({{ $inquiry->id }})"> <i class="fa-solid fa-circle-check"></i> Approve</button>
                                    <button class="btn btn-primary btn-sm" onclick="reject({{ $inquiry->id }})" data-bs-toggle="modal" data-bs-target="#rejectModal"> <i class="fa-solid fa-thumbs-down"></i> Reject</button>
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