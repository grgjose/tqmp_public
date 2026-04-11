<style>
    .img-circle{
        border-radius: 50%;
    }
    .profile-user-img{
        border: 3px solid #adb5bd;
        margin: 0 auto;
        padding: 3px;
        width: 100px;
    }
    .img-fluid{
        max-width: 100%;
        height: auto;
    }
    img{
        vertical-align: middle;
        border-style: none;
    }
</style>
<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Product Details</h3>
    </div>
    <form action="/products-store" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="row mb-3">
                <div class="form-group col-2">
                    <label for="userpic">Product Pictures</label>
                    <input type="file" class="form-control" id="upload_file" name="upload_files[]" accept="image/png, image/jpeg" multiple>
                </div>
                <div class="form-group col-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group col-3">
                    <label for="display_name">Display Name</label>
                    <input type="text" class="form-control" id="display_name" name="display_name">
                </div>
                <div class="form-group col-3">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" required>
                </div>
            </div> 
            <div class="row mb-3">
                <div class="form-group col-2">
                    <label for="category_id">Category</label>
                    <select class="form-control" name="category_id">
                        @foreach($productCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-2">
                    <label for="sub_category_id">Sub Category</label>
                    <select class="form-control" name="sub_category_id">
                        <option value="null">None</option>
                        @foreach($productSubCategories as $sub_category)
                            <option class="option-{{$sub_category->category_id}}" value="{{ $sub_category->id }}">{{ $sub_category->category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-2">
                    <label for="brand">Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand" required>
                </div>
                <div class="form-group col-2">
                    <label for="price">Price</label>
                    ₱<input type="number" class="form-control" id="price" name="price" required>
                </div>
                <div class="form-group col-2">
                    <label for="price">Discounted Price</label>
                    ₱<input type="number" class="form-control" id="discounted_price" name="discounted_price" step="0.01" required>
                </div>
                <div class="form-group col-2">
                    <label for="price">Special Discounted Price</label>
                    ₱<input type="number" class="form-control" id="special_discounted_price" name="special_discounted_price" step="0.01" required>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary" type="submit">Save</button>
            <button class="btn btn-secondary" onclick="hideDetails();">Close</button>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        const $subCategorySelect = $('select[name="sub_category_id"]');
        const $allOptions = $subCategorySelect.find('option');
        $('select[name="category_id"]').on('change', function () {
            const selectedCategory = $(this).val();
            $subCategorySelect.html('');
            const noneOption = '<option value="null">None</option>';
            $subCategorySelect.append(noneOption);
            let firstMatchOption = null;
            $allOptions.each(function () {
                if ($(this).hasClass('option-' + selectedCategory)) {
                    $subCategorySelect.append($(this));
                    if (!firstMatchOption) {
                        firstMatchOption = $(this).val();
                    }
                }
            });
            if (firstMatchOption) {
                $subCategorySelect.val(firstMatchOption);
            }
        });
        $('select[name="category_id"]').trigger('change');
    });
</script>