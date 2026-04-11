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
                <h4 class="card-title">List of Products</h4>
                <div class="ms-auto">
                    <button class="btn btn-success px-4" onclick="productCategoryCreate()"><i class="fa-solid fa-cart-plus"></i> &nbsp; Add Product Category</button>
                </div>
            </div>
            <div class="card-body">
                <p class="text-danger">Note: View a Category to see the Sub-Categories under it</p>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <table id="tbl_categories" class="table is-striped" style="width:100%; text-align: left;">
                    <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th style="width: 20%">Category</th>
                            <th style="width: 40%">Description</th>
                            <th style="width: 30%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productCategories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->category }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <div class="btn-group-sm">
                                    <button class="btn btn-warning btn-sm" id="button{{ $category->id }}" onclick="productCategoryShow({{ $category->id }})" data-bs-toggle="modal" data-bs-target="#viewModal"> <i class="fa-solid fa-eye"></i> View </button>
                                    <button class="btn btn-success btn-sm" onclick="productCategoryUpdate({{ $category->id }})"> <i class="fa-solid fa-pen"></i> Update</button>
                                    <button class="btn btn-primary btn-sm" onclick="productCategoryDelete({{ $category->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal"> <i class="fa-solid fa-trash"></i> Delete</button>
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
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h5 class="modal-title border-0 text-white" id="modalLabel">Category Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="reason">Description</label>
                                <textarea cols="8" rows="2" class="form-control" style="resize: none;" id="reason" name="reason">Category is no longer available</textarea>
                            </div>
                            <div class="form-group col-12" id="subCategories">

                            </div>
                        </div>
                        <div class="row">
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-info" data-bs-dismiss="modal">Add Sub Category</button> --}}
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
            </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title border-0 text-white" id="modalLabel">Delete Product Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteForm" action="/product-categories-destroy/" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="reason">Reason</label>
                                    <textarea cols="10" rows="5" class="form-control" style="resize: none;" id="reason" name="reason">Category is no longer available</textarea>
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