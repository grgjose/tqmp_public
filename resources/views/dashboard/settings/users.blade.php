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
                <h4 class="card-title">List of Active Users</h4>
                <div class="ms-auto">
                    <button class="btn btn-success px-4" onclick="userCreate()"><i class="fa-solid fa-user-plus"></i> &nbsp; Add User</button>
                </div>
            </div>
            <div class="card-body">
                <table id="tbl_users" class="table is-striped" style="width:100%; text-align: left;">
                    <thead>
                        <tr>
                            <th style="width: 15%">Registration Date</th>
                            <th style="width: 15%">First Name</th>
                            <th style="width: 10%">Last Name</th>
                            <th style="width: 10%">Usertype</th>
                            <th style="width: 20%">Email</th>
                            <th style="width: 30%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->fname }}</td>
                            <td>{{ $user->lname }}</td>
                            <td>{{ $user->usertype_title }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="btn-group-sm">
                                    <button class="btn btn-warning btn-sm" onclick="userShow({{ $user->id }})"> <i class="fa-solid fa-eye"></i> View</button>
                                    @if($user->usertype == 3)
                                    <button class="btn btn-info btn-sm" onclick="downloadFile({{ $user->id }})"> <i class="fa-solid fa-file-arrow-down"></i> Download File</button>
                                    @endif
                                    <button class="btn btn-success btn-sm" onclick="userUpdate({{ $user->id }})"> <i class="fa-solid fa-pen"></i> Update</button>
                                    <button class="btn btn-primary btn-sm" onclick="userDelete({{ $user->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal"> <i class="fa-solid fa-trash"></i> Delete</button>
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
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title border-0 text-white" id="modalLabel">Delete User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteForm" action="/users-destroy/" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="reason">Reason</label>
                                    <textarea cols="10" rows="5" class="form-control" style="resize: none;" id="reason" name="reason">No longer Active / Employee of TQMP</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Delete</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>