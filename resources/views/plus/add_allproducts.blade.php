<div class="py-5">
  <div class="row">

    {{-- Search bar --}}
    <div class="mb-4">
        <input
        type="text"
        id="allProductsSearch"
        class="form-control form-control-lg"
        placeholder="Search all products by name, category, SKU, description..."
        >
    </div>

    {{-- No results message --}}
    <div id="allProductsEmpty" class="text-center text-muted py-5" style="display:none;">
      <i class="fas fa-search fa-2x mb-3"></i>
      <p>No products found matching your search.</p>
    </div>

    {{-- Flat product grid --}}
    <div class="row g-3" id="allProductsGrid">
      @foreach ($products as $product)
        @php
          // Resolve the sub-category name for this product
          $subCatName = '';
          $catName = '';
          foreach ($productSubCategories as $sc) {
            if ($sc->id == $product->sub_category_id) {
              $subCatName = $sc->category;
              break;
            }
          }
          foreach ($productCategories as $pc) {
            if ($pc->id == $product->category_id) {
              $catName = $pc->category;
              break;
            }
          }
        @endphp

        <div class="col-6 col-md-4 col-lg-3 d-flex align-items-stretch all-product-item"
             data-name="{{ strtolower($product->name) }} {{ strtolower($product->display_name) }}"
             data-category="{{ strtolower($catName) }}"
             data-subcategory="{{ strtolower($subCatName) }}"
             data-sku="{{ strtolower($product->sku ?? '') }}"
             data-description="{{ strtolower($product->description ?? '') }}">

          <div class="card border-1 d-flex flex-column w-100">
            <img src="{{ asset('storage/all-items/' . $product->image) }}"
                 onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                 alt="{{ $product->display_name }}"
                 class="card-img-top"
                 style="object-fit:cover; width:100%; height:200px; border-radius:8px 8px 0 0;">
            <div class="card-body d-flex flex-column">
              {{-- Category badge --}}
              <span class="badge mb-1" style="background-color:#950101; font-size:0.7rem; width:fit-content;">
                {{ $catName }}{{ $subCatName ? ' › ' . $subCatName : '' }}
              </span>
              <h6 class="card-title text-start fw-bold">{{ $product->display_name }}</h6>
              @if ($my_user->isDiscounted)
                <h6 class="card-text text-start">
                  <small class="text-decoration-line-through text-muted">₱{{ $product->price }}</small>
                  ₱{{ $product->discounted_price }}
                </h6>
              @else
                <h6 class="card-text text-start">₱{{ $product->price }}</h6>
              @endif
              <a href="/add-to-cart/{{ $product->id }}" class="btn btn-danger mt-auto w-100">Add to Cart</a>
            </div>
          </div>

        </div>
      @endforeach
    </div>

  </div>
</div>