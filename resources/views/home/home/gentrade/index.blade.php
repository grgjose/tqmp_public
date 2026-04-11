<!DOCTYPE html>
<html lang="en">

<head>
    @include ('plus.head')
</head>

<body>
    @include('plus.navbar')
    <section id="landing-archi-hardwares" class="hero-wrapper fade-in-up">
        <!-- IMAGE BANNER -->
        <div class="hero-banner"
            style="background-image: url('https://images.pexels.com/photos/834892/pexels-photo-834892.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1');">
        </div>

        <!-- OVERLAPPING LOGO -->
        <div class="hero-logo">
            <img src="{{ asset('storage/logos/TQMPLogo.png') }}" alt="Logo">
        </div>

        <!-- WHITE CONTENT -->
        <div class="container text-center hero-content">
            <h2 class="fw-bold fs-2">Architectural Hardwares</h2>

            With THORE Brand, we are not only seeking a wide range of architectural hardware but also prioritizing strength, endurance, and resistance in our products.

        </div>
    </section>
    {{-- <!-- <section id="landing-archi-hardwares" class="d-flex align-items-center justify-content-center text-center min-vh-100"
        style="background: linear-gradient(rgba(23, 38, 71, 0.3), rgba(126, 20, 22, 0.3)),
                    url('https://images.pexels.com/photos/834892/pexels-photo-834892.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1') no-repeat center center/cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="fw-bold display-3 fade-up" style="color: white;">Architectural Hardwares</h2>
                    <p class="lead mt-3 fade-in" style="color: white;">
                        With THORE Brand, we are not only seeking a wide range of architectural hardware but also prioritizing strength, endurance, and resistance in our products.</p>
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="/catalog" class="card-button btn btn-light fade-in text-decoration-none" style="font-size: smaller;">
                            <span>Find out more</span>
                        </a>
                    </div>
                </div>
            </div>
    </section> --> --}}
    @foreach($productSubCategories as $sub_category)
        @if($sub_category->category_id == 5)
            <section class="py-5">
                <div class="container mb-5 p-4"
                    @if($sub_category->id % 2 == 1)
                        style="background-color:rgba(239, 239, 239, 0.37); border-radius: .25rem;"
                    @endif
                    >

                    <div class="container text-center">
                        <h2 class="fw-bold">{{ $sub_category->category }}</h2>
                        <p class="mt-3">{{ $sub_category->description }}</p>
                        <div id="carouselOtherProduct{{$sub_category->id}}" class="carousel slide" data-bs-ride="false">
                            <div class="carousel-inner">
                                @php
                                    $cnt = 0;
                                    $filtered = $products->where('sub_category_id', $sub_category->id);
                                @endphp
                                @if($filtered->isEmpty())
                                    <div class="col-12 mb-4 align-items-center justify-content-center d-flex">
                                        <h4>No products available in this category.</h4>
                                    </div>
                                @else
                                    @foreach($products as $product)
                                        @if($product->sub_category_id == $sub_category->id)
                                            @php
                                                if($cnt == 0){ $active = 'active'; } else { $active = ''; }
                                            @endphp
                                            @if($cnt % 4 == 0)
                                                <div class="carousel-item {{ $active }}">
                                                    <div class="row mt-4 g-3">
                                            @endif
                                            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                                                <div class="card h-100 border-0 shadow-sm">
                                                    <img
                                                        src="{{ asset('storage/all-items/'.$product->image) }}"
                                                        alt="{{ $product->display_name }}"
                                                        onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                                        class="card-img-top img-fluid"
                                                        style="object-fit: contain; height: 250px;">
                                                    <div class="card-body d-flex flex-column justify-content-between">
                                                        <div>
                                                            <h6 class="card-title mb-2">{{ $product->display_name }}</h6>
                                                            @if($my_user != null)
                                                            <p class="card-text text-muted mb-3">₱{{ $product->price }}</p>
                                                            @endif
                                                        </div>
                                                        <div class="mt-auto">
                                                            @if($my_user != null)
                                                            <a href="/add-to-cart/{{ $product->id }}" class="btn btn-danger w-100">Add to Cart</a>
                                                            @else
                                                            <a href="#" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Order Now</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            @if($cnt % 4 == 3 || $sub_category->product_count - 1 == $cnt)
                                                    </div>
                                                </div>
                                            @endif
                                            @php
                                                $cnt = $cnt + 1;
                                            @endphp
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselOtherProduct{{$sub_category->id}}" data-bs-slide="prev" style="left: -180px; color: #841617;">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class=""><i class="fa-solid fa-circle-chevron-left"></i></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselOtherProduct{{$sub_category->id}}" data-bs-slide="next" style="right: -180px; color: #841617;">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class=""><i class="fa-solid fa-circle-chevron-right"></i></span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endforeach
    @include ('plus.scripts')
    @include ('plus.cta')
    @include ('plus.accordion')
    @include ('plus.chatbot')
    @include ('plus.footer')
</body>

</html>