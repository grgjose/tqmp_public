<style>
    .image-container {
        position: relative;
        display: inline-block;
        margin: 5px;
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
        cursor: pointer;
        transition: opacity 0.2s ease-in-out;
    }
    .image-checkbox {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        opacity: 0;
        cursor: pointer;
    }
    .checkmark {
        position: absolute;
        top: 5px;
        right: 5px;
        width: 24px;
        height: 24px;
        background-color: rgba(0, 0, 0, 0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
        font-weight: bold;
        opacity: 0;  
        transition: opacity 0.2s ease-in-out;
    }
    .image-checkbox:checked + img {
        opacity: 0.5;
    }
    .image-checkbox:checked + img + .checkmark {
        opacity: 1;  
    }
</style>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Product Details</h3>
    </div>
    <form action="/catalogue-update/{{ $catalogue->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="form-group col-12">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $catalogue->title }}" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="form-group col-12">
                        <label for="userpic">Replace Catalogue Image</label>
                        <input type="file" class="form-control" id="upload_file" name="upload_file" accept="image/png, image/jpeg">
                    </div>
                </div> 
                <div class="row mb-3">
                    <div class="col-12">
                        <label>Current Catalogue Image</label>
                        <div class="product-images d-flex flex-wrap">
                            <div class="col-md-3 col-sm-6 col-6 text-center image-container border border-dark">
                                <img id="img-{{ $catalogue->id }}" src="{{ asset('storage/catalogue/' . $catalogue->upload_file) }}" 
                                class="product-image" alt="Product Image">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Save</button>
            <button class="btn btn-primary" onclick="hideDetails();">Close</button>
        </div>
    </form> 
</div>