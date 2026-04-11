<!DOCTYPE html>
<html lang="en">

<head>
    @include ('plus.head')
</head>

<body>
    @include('plus.navbar')
    <section id="landing-bulletproofing" class="hero-wrapper fade-in-up">
        <!-- IMAGE BANNER -->
        <div class="hero-banner"
            style="background-image: url('storage/glass-mfg/{{ $settings['GLASS_MFG_BANNER_IMAGE'] }}');">
        </div>

        <!-- OVERLAPPING LOGO -->
        <div class="hero-logo">
            <img src="{{ asset('storage/logos/pioneer_logo.png') }}" alt="Logo">
        </div>

        <!-- WHITE CONTENT -->
        <div class="container text-center hero-content">
            <h2 class="fw-bold fs-2">Glass Manufacturing</h2>

            {!! $settings['GLASS_MFG_BANNER_DESC'] !!} <br><br>

            <a href="/about" target="_blank"
                class="btn btn-danger px-4 py-2">
                Find out more
            </a>
        </div>
    </section>

    {{-- <!-- <section id="landing-glass-manufacturing" class="d-flex align-items-center justify-content-center text-center min-vh-100"
        style="background: linear-gradient(rgba(23, 38, 71, 0.4), rgba(126, 20, 22, 0.3)),
                    url('storage/glass-mfg/{{ $settings['GLASS_MFG_BANNER_IMAGE'] }}') no-repeat center center/cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    {!! $settings['GLASS_MFG_BANNER_TITLE'] !!}
                    {!! $settings['GLASS_MFG_BANNER_DESC'] !!}
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="https://www.pfg.com.ph/" class="card-button btn btn-light fade-in text-decoration-none" style="font-size: smaller;">
                            <span>Find out more</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section> --> --}}

    <section id="about-glass-manufacturing" class="fade-in-up">
         <div class="container py-5">
            <div class="row">
                {{-- <!-- <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('storage/glass-mfg/' . $settings['GLASS_MFG_ABOUT_US_IMAGE']) }}" alt="Bullet Proofing" class="img-fluid rounded-lg" style="padding: 20px;">
                </div> --> --}}
                <div class="col-lg-12">
                    <div class="card-body py-5">
                        <h2 class="fw-bold">About us</h2>
                        {!! $settings['GLASS_MFG_ABOUT_US_DESC'] !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="products-glass-manufacturing" class="py-5 fade-in-up">
        <div class="container ">
            <div class="container text-center">
                <h2 class="fw-bold">Products</h2>
                <p class="mt-3">
                    With over six decades of expertise in the national flat glass manufacturing industry, PFGMI specializes in producing high-quality flat glass, including Clear Float and Tinted Float. Our dedication extends beyond the glass industry, reflecting a broader commitment to excellence.
                </p>
            </div>

            @php
            class Product{
            public $title;
            public $description;
            public $image;
            public $details;

            public function __construct($title, $description, $image, $details) {
            $this->title = $title;
            $this->description = $description;
            $this->image = $image;
            $this->details = $details;
            }
            }

            $products = [];

            $count = $settings_raw->filter(fn($item) => str_contains($item->key, 'GLASS_MFG_PRODUCTS'))->count();
            $count = $count / 4; // Each product has 4 fields: title, desc, image, details
            $itemsPerPage = 3; // Number of products per page

            for ($i = 1; $i <= $count; $i++) {
                $title=$settings['GLASS_MFG_PRODUCTS_TITLE' . $i];
                $description=$settings['GLASS_MFG_PRODUCTS_DESC' . $i];
                $image=$settings['GLASS_MFG_PRODUCTS_IMAGE' . $i];
                $details=$settings['GLASS_MFG_PRODUCTS_DETAILS' . $i];
                array_push($products, new Product($title, $description, $image, $details));
                }

                @endphp

                <div class="container py-5">
                {{-- TAB CONTENT --}}
                <div class="tab-content" id="pagination-content">
                    @foreach($products as $product)

                    @if($loop->index % $itemsPerPage == 0)
                    <div class="tab-pane fade @if($loop->index == 0) show active @endif" id="page-{{ intdiv($loop->index + 1, $itemsPerPage) }}" role="tabpanel">
                        <div class="row py-3 g-4">
                            @endif


                            <div class="col-12 col-md-6 col-lg-4 d-flex align-items-stretch">
                                <div class="card border-0 shadow-sm d-flex flex-column w-100">
                                    <img src="{{ asset('storage/glass-mfg/' . $product->image) }}"
                                        onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                        alt="{{ $product->title }}"
                                        class="card-img-top"
                                        style="object-fit: cover; width: 100%; height: 250px; border-radius:8px 8px 0 0;">

                                    <div class="card-body d-flex flex-column">
                                        <h6 class="fw-bold">{{ $product->title }}</h6>
                                        <p class="card-text text-muted">{{ $product->description }}</p>
                                        <a class="btn btn-danger mt-auto w-100" data-bs-toggle="collapse" href="#accordion{{ $loop->index }}" role="button">
                                            More Details
                                        </a>
                                        <div id="accordion{{ $loop->index }}" class="collapse mt-3">
                                            <div class="accordion-body">
                                                {!! $product->details !!}
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button type="button" class="btn btn-secondary w-50" data-bs-toggle="collapse" data-bs-target="#accordion{{ $loop->index }}">Close</button>
                                                    @if($my_user != null)
                                                    <a href="/shop" class="btn btn-primary w-50">Order Now</a>
                                                    @else
                                                    <a href="#" class="btn btn-primary w-50" data-bs-toggle="modal" data-bs-target="#loginModal">Order Now</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($loop->index % $itemsPerPage == 2 || $loop->index == count($products) - 1)
                        </div>
                    </div>
                    @endif

                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <ul class="nav nav-pills justify-content-center flex-column flex-sm-row">
                            @for($i = 1; $i <= intdiv(count($products) + 1, $itemsPerPage); $i++)
                                <li class="nav-item" role="presentation">
                                <button class="nav-link px-3 py-2 fs-6 @if($i == 1) active @endif"
                                    data-bs-toggle="pill"
                                    data-bs-target="#page-{{ $i - 1 }}"
                                    type="button" role="tab">{{ $i }}</button>
                                </li>
                                @endfor
                        </ul>
                    </div>
                </div>

        </div>

    </section>
    <section id="awards" class="container">
        <div class="container py-5 mt-5 fade-in-up">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-6">
                    <div class=" d-flex justify-content-center align-items-center h-100">
                        <img src="{{ asset('storage/glass-mfg/'.$settings['GLASS_MFG_AWARDS_IMAGE']) }}" alt="Philippines" class="img-fluid rounded-lg" style="padding: 20px;">
                    </div>
                </div>
                <div class="col-lg-6 py-3">
                    <div class="our-story">
                        <h2 class="fw-bold">Awards and Recognition</h2>
                        {!! $settings['GLASS_MFG_AWARDS_DESC'] !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include ('plus.scripts')
    {{-- <!-- @include ('plus.cta') --> --}}
    @include ('plus.accordion')
    @include ('plus.chatbot')
    @include ('plus.footer')
</body>

</html>