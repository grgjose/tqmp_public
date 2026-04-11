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
    <div class="card-body">
        <div class="row mb-3">
            <div class="form-group col-3">
                <label for="fname">Name</label>
                <input type="text" class="form-control" id="name" value="{{ $product->name }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="mname">Display Name</label>
                <input type="text" class="form-control" id="display_name" value="{{ $product->display_name }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="lname">Description</label>
                <input type="text" class="form-control" id="description" value="{{ $product->description }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="category_id">Category</label>
                <select class="form-control" name="category_id" value="{{ $product->category_id }}" disabled>
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
        </div> 
        <div class="row mb-3">
            <div class="form-group col-3">
                <label for="brand">Brand</label>
                <input type="text" class="form-control" id="brand" value="{{ $product->brand }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="price">Price</label>
                ₱<input type="number" class="form-control" id="price" value="{{ $product->price }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="price">Discounted Price</label>
                ₱<input type="number" class="form-control" id="price" value="{{ $product->discounted_price }}" readonly>
            </div>
            <div class="form-group col-3">
                <label for="price">Special Discounted Price</label>
                ₱<input type="number" class="form-control" id="price" value="{{ $product->special_discounted_price }}" readonly>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <label>Product Images</label>
                <div class="product-images d-flex flex-wrap">
                    @foreach($productImages as $image)
                        @if($image->product_id == $product->id)
                            <div class="col-md-3 col-sm-6 col-6 text-center image-container border border-dark">
                                <input type="checkbox" class="image-checkbox" id="img-checkbox-{{ $image->id }}" name="images_to_delete[]" value="{{ $image->id }}">
                                <img id="img-{{ $image->id }}" src="{{ asset('storage/all-items/' . $image->filename) }}" 
                                class="product-image" alt="Product Image" onclick="toggleProductCheckbox({{ $image->id }})">
                                <div class="checkmark" id="checkmark-{{ $image->id }}">✔</div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button class="btn btn-primary" onclick="hideDetails();">Close</button>
    </div>
</div>