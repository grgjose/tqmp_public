<main class="app-main px-4">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ $title }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
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
                <h4 class="card-title">Product Variants per Product</h4>
                <div class="ms-auto">
                    <button class="btn btn-success px-4" onclick="productVariantCreate()"><i class="fa-solid fa-cart-plus"></i> &nbsp; Add Product Variant</button>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs mb-3" id="variantTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="variants-tab" data-bs-toggle="tab" data-bs-target="#variants" type="button" role="tab">Variants</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="mappings-tab" data-bs-toggle="tab" data-bs-target="#mappings" type="button" role="tab">Mappings</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="keys-tab" data-bs-toggle="tab" data-bs-target="#keys" type="button" role="tab">Keys</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="values-tab" data-bs-toggle="tab" data-bs-target="#values" type="button" role="tab">Values</button>
                    </li>
                </ul>
                <div class="tab-content" id="variantTabContent">
                    <div class="tab-pane fade show active" id="variants" role="tabpanel">
                        @include('dashboard.settings.product-variants-table')
                    </div>
                    <div class="tab-pane fade" id="mappings" role="tabpanel">
                        @include('dashboard.settings.product-variants-mappings')
                    </div>
                    <div class="tab-pane fade" id="keys" role="tabpanel">
                        @include('dashboard.settings.product-variants-keys')
                    </div>
                    <div class="tab-pane fade" id="values" role="tabpanel">
                        @include('dashboard.settings.product-variants-values')
                    </div>
                </div>
            </div>
        </div>
        <div id="view">
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title border-0 text-white" id="modalLabel">Delete Product Variant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="deleteForm" action="/product-variants-destroy/" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="reason">Reason</label>
                                    <textarea cols="10" rows="5" class="form-control" style="resize: none;" id="reason" name="reason">Variant is no longer available</textarea>
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
