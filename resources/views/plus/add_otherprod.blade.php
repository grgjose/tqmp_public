<div class="py-5">
  <div class="row">
    <div class="mb-3">
      <input
          type="text"
          id="productSearch3"
          class="form-control form-control-lg"
          placeholder="Search other products..."
      >
    </div>
    <div class="col-12 col-md-3 mb-3 mb-md-0 pe-md-0">
      <div class="nav flex-row flex-md-column nav-pills me-md-3 border-end border-md-2"
           id="subcategory5-tabs"
           role="tablist"
           style="border-right-color:#841617; overflow-x:auto; white-space:nowrap;">
        @php $isFirst = true; @endphp
        @foreach($productSubCategories as $sub_category)
          @if($sub_category->category_id == 5)
            <button class="nav-link mt-2 me-2 me-md-0 {{ $isFirst ? 'active' : '' }}"
                    id="tab5-{{ $sub_category->id }}"
                    data-bs-toggle="tab"
                    data-bs-target="#pane5-{{ $sub_category->id }}"
                    type="button"
                    role="tab"
                    aria-controls="pane5-{{ $sub_category->id }}"
                    aria-selected="{{ $isFirst ? 'true' : 'false' }}">
              {{ $sub_category->category }}
            </button>
            @php $isFirst = false; @endphp
          @endif
        @endforeach
      </div>
    </div>
    <div class="col-12 col-md-9 tab-content-container">
      <div class="tab-content" id="subcategory5-content">
        @php $isFirst = true; @endphp
        @foreach($productSubCategories as $sub_category)
          @if($sub_category->category_id == 5)
            <div class="tab-pane fade {{ $isFirst ? 'show active' : '' }}"
                 id="pane5-{{ $sub_category->id }}"
                 role="tabpanel"
                 aria-labelledby="tab5-{{ $sub_category->id }}">
              <div class="container mt-2">
                <div class="row py-3 g-3">
                  @foreach($products as $product)
                    @if($product->sub_category_id == $sub_category->id)
                      <div class="col-6 col-md-4 col-lg-3 d-flex align-items-stretch product-item"
                          data-name="{{ strtolower($product->display_name) }}"
                          data-category="{{ strtolower($sub_category->category) }}">
                        <div class="card border-1 d-flex flex-column w-100">
                          <img src="{{ asset('storage/all-items/'.$product->image) }}"
                               onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                               alt="{{ $product->display_name }}"
                               class="card-img-top"
                               style="object-fit:cover; width:100%; height:200px; border-radius:8px 8px 0 0;">
                          <div class="card-body d-flex flex-column">
                            <h6 class="card-title text-start fw-bold">{{ $product->display_name }}</h6>
                            @if($my_user->isDiscounted)
                              <h6 class="card-text text-start">
                                <small class="text-decoration-line-through text-muted">₱{{ $product->price }}</small>
                                ₱{{ $product->discounted_price }}
                              </h6>
                            @else
                              <h6 class="card-text text-start">₱{{ $product->price }}</h6>
                            @endif
                            <a href="/add-to-cart/{{ $product->id }}"
                               class="btn btn-danger mt-auto w-100">Add to Cart</a>
                          </div>
                        </div>
                      </div>
                    @endif
                  @endforeach
                </div>
              </div>
            </div>
            @php $isFirst = false; @endphp
          @endif
        @endforeach
      </div>
    </div>
  </div>
</div>
