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
    <form action="/products-update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card-body">
                <div class="row mb-3">
                    <div class="form-group col-2">
                        <label for="userpic">Add Product Pictures</label>
                        <input type="file" class="form-control" id="upload_file" name="upload_files[]" accept="image/png, image/jpeg" multiple>
                    </div>
                    <div class="form-group col-3">
                        <label for="fname">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required>
                    </div>
                    <div class="form-group col-3">
                        <label for="mname">Display Name</label>
                        <input type="text" class="form-control" id="display_name" name="display_name" value="{{ $product->display_name }}" required>
                    </div>
                    <div class="form-group col-3">
                        <label for="lname">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ $product->description }}" required>
                    </div>
                </div> 
                <div class="row mb-3">
                    <div class="form-group col-2">
                        <label for="category_id">Category</label>
                        <select class="form-control" name="category_id" value="{{ $product->category_id }}">
                            @foreach($productCategories as $category)
                                <option value="{{ $category->id }}" 
                                @if($category->id == $product->category_id)
                                    selected
                                @endif
                                >
                                {{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <label for="sub_category_id">Sub Category</label>
                        <select class="form-control" name="sub_category_id" value="{{ $product->sub_category_id }}">
                            @foreach($productSubCategories as $sub_category)
                                <option value="{{ $sub_category->id }}" 
                                @if($sub_category->id == $product->sub_category_id)
                                    selected
                                @endif
                                >
                                {{ $sub_category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-2">
                        <label for="brand">Brand</label>
                        <input type="text" class="form-control" id="brand" name="brand" value="{{ $product->brand }}" required>
                    </div>
                    <div class="form-group col-2">
                        <label for="price">Price</label>
                        ₱<input type="number" class="form-control" id="price" name="price" value="{{ $product->price }}" required>
                    </div>
                    <div class="form-group col-2">
                        <label for="price">Discounted Price</label>
                        ₱<input type="number" class="form-control" id="discounted_price" name="discounted_price" value="{{ $product->discounted_price }}" step="0.01" required>
                    </div>
                    <div class="form-group col-2">
                        <label for="price">Special Discounted Price</label>
                        ₱<input type="number" class="form-control" id="special_discounted_price" 
                        name="special_discounted_price" value="{{ $product->special_discounted_price }}" step="0.01" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label>Product Images</label>
                        <p style="color: red;">Click the images you want to be deleted</p>
                        <div class="product-images d-flex flex-wrap">
                            @foreach($productImages as $image)
                                @if($image->product_id == $product->id)
                                    <div class="col-md-3 col-sm-6 col-6 text-center image-container border border-dark" onclick="toggleProductCheckbox({{ $image->id }})">
                                        <input type="checkbox" class="image-checkbox" id="img-checkbox-{{ $image->id }}" name="images_to_delete[]" value="{{ $image->id }}">
                                        <img id="img-{{ $image->id }}" src="{{ asset('storage/all-items/' . $image->filename) }}" 
                                        class="product-image" alt="Product Image">
                                        <div class="checkmark" id="checkmark-{{ $image->id }}">✔</div>
                                    </div>
                                @endif
                            @endforeach
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