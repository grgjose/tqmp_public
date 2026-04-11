<section id="services-glass-processing" class="container py-4">
    <div class="container mt-5 text-center">
        <h2 class="fw-bold">Glass Processing Services</h2>
        <p>PGPSI offers the following glass processing services</p>
    </div>
    <div class="row py-3">
        @foreach($products as $product)
            @if($product->category_id == 4)
                <div class="col-md-3 mb-4 d-flex align-items-stretch">
                    <div class="card border-0 shadow-sm d-flex flex-column">
                        <img src="{{ asset('storage/all-items/'.$product->image) }}" alt="{{$product->display_name}}" class="card-img-top" style="object-fit: cover; width: 100%; height: 200px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold">{{$product->display_name}}</h6>
                            <p class="card-text flex-grow-1">{{$product->description}}</p>
                            <a href="/#" class="card-button btn btn-danger mt-auto get-quotation-button w-100"
                                @if($my_user==null)
                                data-bs-toggle="modal" data-bs-target="#loginModal"
                                @endif>Get Quotation</a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
            </div>
</section>