<table id="tbl_mappings" class="table is-striped" style="width:100%; text-align: left;">
    <thead>
        <tr>
            <th style="width: 30%">Product Variant</th>
            <th style="width: 20%">Key</th>
            <th style="width: 20%">Value</th>
            <th style="width: 30%">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($productVariants as $variant)
            <tr>
                <td>
                    @foreach($products as $product)
                        @if($product->id == $variant->product_id)
                            {{ $product->name; }}
                            @continue
                        @endif
                    @endforeach
                </td>
                <td>{{ $variant->key }}</td>
                <td>{{ $variant->value }}</td>
                                <td>
                    <div class="btn-group-sm">
                        <button class="btn btn-success btn-sm" onclick="productVariantUpdate({{ $variant->id }})"> <i class="fa-solid fa-pen"></i> Update</button>
                        <button class="btn btn-primary btn-sm" onclick="productVariantDelete({{ $variant->id }})" data-bs-toggle="modal" data-bs-target="#deleteModal"> <i class="fa-solid fa-trash"></i> Delete</button>
                                            </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>