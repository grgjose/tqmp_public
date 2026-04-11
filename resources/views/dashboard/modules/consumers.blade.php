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
                        <h4 class="card-title">Customers List (Consumers)</h4>
                    </div>
                    <div class="card-body">
                        <table id="tbl_consumers" class="table is-striped" style="width:100%; text-align: left;">
                            <thead>
                                <tr>
                                    <th>Customer ID</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Address</th>
                                    <th>Discounted?</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->code }}</td>
                                    <td>{{ $user->fname }}</td>
                                    <td>{{ $user->lname.' '.$user->ext }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>
                                        @if($user->isSpecialDiscounted == true)
                                            "Special Discount"
                                        @elseif($user->isDiscounted == true)
                                            "Normal Discount"
                                        @else
                                            "None"
                                        @endif

                                    </td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{ $user->status }}
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Active</a></li>
                                                <li><a class="dropdown-item" href="#">Inactive</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group-sm">
                                            <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                Actions
                                            </button>
                                            <ul class="dropdown-menu">
                                                @if($user->isDiscounted)
                                                <li><a class="dropdown-item" href="/remove-discount/{{$user->id}}">Remove Discount</a></li>
                                                <li><a class="dropdown-item" href="/apply-special-discount/{{$user->id}}">Apply Special Discount</a></li>
                                                @elseif($user->isSpecialDiscounted)
                                                <li><a class="dropdown-item" href="/remove-discount/{{$user->id}}">Remove Discount</a></li>
                                                <li><a class="dropdown-item" href="/apply-discount/{{$user->id}}">Apply Normal Discount</a></li>
                                                @else
                                                <li><a class="dropdown-item" href="/apply-discount/{{$user->id}}">Apply Discount</a></li>
                                                <li><a class="dropdown-item" href="/apply-special-discount/{{$user->id}}">Apply Special Discount</a></li>
                                                @endif
                                                <li><a class="dropdown-item" href="#">View</a></li>
                                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal">Delete</a></li>
                                            </ul>
                                            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-primary">Delete</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>