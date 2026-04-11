<br>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Sub-Categories</h5>
    <button 
        class="btn btn-primary btn-sm"
        onclick="addSubCategory({{ $category_id }})">
        <i class="fa-solid fa-plus"></i> Add Sub Category
    </button>
</div>

<table class="table table-bordered table-striped" id="tbl_sub_categories">
    <thead>
        <tr>
            
            <th style="width:35%">Sub-Category</th>
            <th style="width:50%">Description</th>
            <th style="width:15%">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subCategories as $sub)
        <tr>
            
            <td>{{ $sub->category }}</td>
            <td>{{ $sub->description }}</td>
            <td>
                <button class="btn btn-success btn-sm" onclick="editSubCategory({{ $sub->id }})">
                    <i class="fa-solid fa-pen"></i>
                </button>
                <button class="btn btn-danger btn-sm" onclick="deleteSubCategory({{ $sub->id }})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="modal fade" id="subCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="subCategoryModalLabel">Add Sub-Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="subCategoryForm" action="/product-sub-categories-store" method="POST">
                @csrf
                <input type="hidden" name="category_id" id="parentCategoryId">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sub-Category Name</label>
                        <input type="text" name="category" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" style="resize:none;"></textarea>
                    </div>
                    <input type="hidden" name="category_id" value="{{ $category_id }}">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="subCategoryEditModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="subCategoryEditModalLabel">Edit Sub-Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="subCategoryEditForm" action="/product-sub-categories-update/" method="POST">
                @csrf
                <input type="hidden" name="category_id" id="parentCategoryId">

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Sub-Category Name</label>
                        <input type="text" id="category" name="category" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="description" class="form-control" rows="3" style="resize:none;"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Save</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Close</button>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="subCategoryDeleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Delete Sub-Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="subCategoryDeleteForm" method="POST">
                @csrf
                <div class="modal-body">
                    <p>Are you sure you want to delete this sub-category?</p>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" type="submit">Delete</button>
                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $('#tbl_sub_categories').DataTable({
        scrollY: "200px",    // Fixed height
        scrollCollapse: true,
        paging: true        // Optional: hide pagination if you want scrolling only
    });

    document.addEventListener('shown.bs.modal', function (event) {
        let zIndex = 1050 + (10 * document.querySelectorAll('.modal.show').length);
        let modal = event.target;

        modal.style.zIndex = zIndex;

        setTimeout(() => {
            document.querySelectorAll('.modal-backdrop')
                .forEach(backdrop => backlog.style.zIndex = zIndex - 1);
        });
    });

    function addSubCategory(categoryId) {

        // Set the parent category ID for the form
        $('#parentCategoryId').val(categoryId);

        // Change modal title if needed
        $('#subCategoryModalLabel').text('Add Sub-Category');

        // Open the second modal on top of the first
        $('#subCategoryModal').modal('show');
    }

    function editSubCategory(subCategoryId) {
        // Get the table row containing this sub-category
        let row = $('button[onclick="editSubCategory(' + subCategoryId + ')"]').closest('tr');

        // Extract values from the row
        let category = row.find('td:eq(0)').text().trim();
        let description = row.find('td:eq(1)').text().trim();

        // Set form action (so it updates the correct record)
        $('#subCategoryEditForm').attr('action', '/product-sub-categories-update/' + subCategoryId);

        // Populate modal fields
        $('#subCategoryEditForm #category').val(category);
        $('#subCategoryEditForm #description').val(description);

        // Show the modal
        $('#subCategoryEditModal').modal('show');
    }

    function deleteSubCategory(subCategoryId) {

        // Set the form action inside the modal
        $('#subCategoryDeleteForm').attr('action', '/product-sub-categories-destroy/' + subCategoryId);

        // Show the delete confirmation modal
        $('#subCategoryDeleteModal').modal('show');
    }
</script>