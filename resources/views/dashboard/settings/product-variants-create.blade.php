<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Product Details</h3>
    </div>
    <form action="/product-variants-store" method="POST">
        @csrf
        <div class="card-body">
            <div class="row mb-3">
                <div class="form-group col-4">
                    <label for="product_id">Product</label>
                    <select class="form-control" name="product_id" required>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-4">
                    <label for="key">Variant</label>
                    <select class="form-control" name="key" required>
                        <option value="Size">Size</option>
                        <option value="Color">Color</option>
                        <option value="Brand">Brand</option>
                    </select>
                </div>
                <div class="form-group col-4">
                    <label for="value">Value</label>
                    <input type="text" class="form-control" id="value" name="value" required>
                </div>
            </div> 
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-secondary" onclick="hideDetails();">Close</button>
        </div>
    </form>
</div>