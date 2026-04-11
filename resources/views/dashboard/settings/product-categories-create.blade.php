<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Product Category Details</h3>
    </div>
    <form action="/product-categories-store" method="POST">
        @csrf
        <div class="card-body">
            <div class="row mb-3">
                <div class="form-group col-12">
                    <label for="category">Category</label>
                    <input type="text" class="form-control" id="category" name="category" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="form-group col-12">
                    <label for="description">Description</label>
                    <textarea cols="10" rows="5" class="form-control" style="resize: none;" id="description" name="description" required></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">Save</button>
            <button class="btn btn-primary" onclick="hideDetails();">Close</button>
        </div>
    </form>
</div>