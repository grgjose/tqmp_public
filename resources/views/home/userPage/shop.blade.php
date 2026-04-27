<!DOCTYPE html>
<html lang="en">

<head>
    @include ('plus.head')
</head>

<body>
    @include('plus.navbar')

    <section id="landing-shop" class="hero-wrapper fade-in-up">
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
            <h2 class="fw-bold fs-2">Welcome! Come shop with us!</h2>

            Explore our wide range of quality products and find what you need to enhance your experience with us.

        </div>
    </section>

    {{-- <!-- <section id="title">
            <div class="container text-center mt-5 fade-in-up">
                <span class="badge text-white mb-2" style="background-color: #950101; font-size:large;">Shop</span>
                <h2 class="fw-bold">Welcome! Come shop with us!</h2>
                <p class="mt-3">
                    Explore our wide range of quality products and find what you need to enhance your experience with us.
                </p>
            </div>
        </section> --> --}}
    <section class="container text-center fade-in-up py-3 mt-5">
        <ul class="nav nav-underline justify-content-start d-flex align-items-stretch justify-content-md-center flex-nowrap overflow-x-auto pb-2 px-2" id="servicesNav" style="scrollbar-width: thin;">
            {{-- NEW: All Products tab (default) --}}
            {{-- <li class="nav-item flex-shrink-0">
                <a class="nav-link active" href="#all-products" data-bs-toggle="tab">
                    <i class="fas fa-th-large me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">All Products</span>
                    <span class="d-inline d-md-none">All</span>
                </a>
            </li> --}}
            <li class="nav-item flex-shrink-0">
                <a class="nav-link active" href="#glass-manufacturing" data-bs-toggle="tab">   
                    <i class="fas fa-industry me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Glass Manufacturing</span>
                    <span class="d-inline d-md-none">Glass</span>
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link" href="#aluminum-manufacturing" data-bs-toggle="tab">
                    <i class="fas fa-cogs me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Aluminum Manufacturing</span>
                    <span class="d-inline d-md-none">Aluminum</span>
                </a>
            </li>
            <li class="nav-item flex-shrink-0">
                <a class="nav-link" href="#other-products" data-bs-toggle="tab">
                    <i class="fa-solid fa-box-open me-1 me-md-2"></i>
                    <span class="d-none d-md-inline">Other Products</span>
                    <span class="d-inline d-md-none">Others</span>
                </a>
            </li>
        </ul>
        <div class="tab-content mt-3" id="servicesTabContent">

            {{-- NEW: All Products pane (default active)
            <div class="tab-pane fade fade-in-up show active" id="all-products">
                @include('plus.add_allproducts')
            </div> --}}

            <div class="tab-pane fade fade-in-up show active" id="glass-manufacturing">
                @include('plus.add_glassmfg')
            </div>
            <div class="tab-pane fade fade-in-up" id="aluminum-manufacturing">
                @include('plus.add_alummfg')
            </div>
            <div class="tab-pane fade fade-in-up" id="other-products">
                @include('plus.add_otherprod')
            </div>

        </div>
    </section>
    @include('plus.chatbot')
    @include ('plus.footer')
    @include ('plus.scripts')
</body>

</html>