<table id="tbl_subCategories" class="table is-striped" style="width:100%; text-align: left;">
    <thead>
        <tr>
            <th style="width: 20%">Category</th>
            <th style="width: 40%">Description</th>
            <th style="width: 30%">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productCategories as $category)
            <tr>
                <td>{{ $category->category }}</td>
                <td>{{ $category->description }}</td>
                                <td>
                    <div class="btn-group-sm">
                        <button class="btn btn-success btn-sm" onclick="productCategoryUpdate({{ $category->id }})"> <i class="fa-solid fa-pen"></i> Update</button>
                        <button class="btn btn-primary btn-sm" onclick="productCategoryDelete({{ $category->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal"> <i class="fa-solid fa-trash"></i> Delete</button>
                                            </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>