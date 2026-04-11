<!DOCTYPE html>
<html lang="en">

<head>
    @include ('plus.head')
</head>

<body>
    @include('plus.navbar')
    <section id="landing-glass-processing" class="hero-wrapper fade-in-up">
        <!-- IMAGE BANNER -->
        <div class="hero-banner"
            style="background-image:   url('storage/glass-processing/{{ $settings['GLASS_PRO_BANNER_IMAGE'] }}');">
        </div>

        <!-- OVERLAPPING LOGO -->
        <div class="hero-logo">
            <img src="{{ asset('storage/logos/pgpsi-logo2.png') }}" alt="Logo">
        </div>

        <!-- WHITE CONTENT -->
        <div class="container text-center hero-content">
            <h2 class="fw-bold fs-2">Glass Processing</h2>

            {!! $settings['GLASS_PRO_BANNER_DESC'] !!} <br><br>

            <a href="/about" target="_blank" class="btn btn-danger px-4 py-2">
                Find out more
            </a>
        </div>
    </section>
    {{-- <!-- <section id="landing-glass-processing" class="d-flex align-items-center justify-content-center text-center min-vh-100"
        style="background: linear-gradient(rgba(23, 38, 71, 0.3), rgba(126, 20, 22, 0.4)),
                    url('storage/glass-processing/{{ $settings['GLASS_PRO_BANNER_IMAGE'] }}') no-repeat center center/cover;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    {!! $settings['GLASS_PRO_BANNER_TITLE'] !!}
                    {!! $settings['GLASS_PRO_BANNER_DESC'] !!}
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="https://www.facebook.com/share/14g3o8X6qi/" class="card-button btn btn-light fade-in text-decoration-none" style="font-size: smaller;">
                            <span>Find out more</span>
                        </a>
                    </div>
                </div>
            </div>
    </section> --> --}}
    <section id="about-glass-processing" class="fade-in-up">
        <div class="container py-5">
            <div class="row">
                {{-- <!-- <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('storage/glass-processing/'. $settings['GLASS_PRO_ABOUT_US_IMAGE']) }}" alt="Glass Processing" class="img-fluid rounded-lg" style="padding: 20px;">
                </div> --> --}}
                <div class="col-lg-12">
                    <div class="card-body">
                        <h2 class="fw-bold">About us</h2>
                        {!! $settings['GLASS_PRO_ABOUT_US_DESC'] !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

    @php
        class Services
        {
            public $title;
            public $image;
            public $description;

            public function __construct($title, $image, $description)
            {
                $this->title = $title;
                $this->image = $image;
                $this->description = $description;
            }
        }

        $services = [];

        $count = $settings_raw->filter(fn($item) => str_contains($item->key, 'GLASS_PRO_SERVICES'))->count();
        $count = $count / 3; // Each product has 3 fields: title, image, description
        $itemsPerPage = 3; // Number of products per page

        for ($i = 1; $i <= $count; $i++) {
            $title = $settings['GLASS_PRO_SERVICES_TITLE' . $i];
            $image = $settings['GLASS_PRO_SERVICES_IMAGE' . $i];
            $description = $settings['GLASS_PRO_SERVICES_DESC' . $i];
            array_push($services, new Services($title, $image, $description));
        }

    @endphp

    <section id="services-glass-processing" class="container py-4">
        <div class="container mt-5 text-center">
            <h2 class="fw-bold">Glass Processing Services</h2>
            <p>PGPSI offers the following glass processing services</p>
        </div>
        <div class="row py-3">

            @foreach ($services as $service)
                <div class="col-md-3 mb-4 d-flex align-items-stretch">
                    <div class="card border-0 shadow-sm d-flex flex-column">
                        <img src="{{ asset('storage/glass-processing/' . $service->image) }}"
                            alt="TQMP {{ $service->title }}" class="card-img-top"
                            style="object-fit: cover; width: 100%; height: 200px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold">{{ $service->title }}</h6>
                            <p class="card-text flex-grow-1">{{ $service->description }}</p>
                            @if ($my_user != null)
                                <a href="/get-quotation-glassprocessing"
                                    class="btn btn-danger mt-auto get-quotation-button w-100">Get Quotation</a>
                            @else
                                <a href="#" class="btn btn-danger mt-auto get-quotation-button w-100"
                                    data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- <div class="col-md-3 mb-4 d-flex align-items-stretch">
                <div class="card border-0 shadow-sm d-flex flex-column">
                    <img src="{{ asset('storage/glass-processing/tempered.png') }}" alt="TQMP Tempered Glass" class="card-img-top" style="object-fit: cover; width: 100%; height: 200px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
            <div class="card-body d-flex flex-column">
                <h6 class="fw-bold">Tempered Glass</h6>
                <p class="card-text flex-grow-1">Fully tempered glass is a unique glazing material. It is about 3 to 5 times stronger than an ordinary or annealed glass of the same thickness and configuration.</p>
                @if ($my_user != null)
                <a href="/get-quotation-glassprocessing" class="btn btn-danger mt-auto get-quotation-button w-100">Get Quotation</a>
                @else
                <a href="#" class="btn btn-danger mt-auto get-quotation-button w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                @endif
            </div>
        </div>
        </div>
        <div class="col-md-3 mb-4 d-flex align-items-stretch">
            <div class="card border-0 shadow-sm d-flex flex-column">
                <img src="{{ asset('storage/glass-processing/laminated.png') }}" alt="TQMP Laminated Glass" class="card-img-top" style="object-fit: cover; width: 100%; height: 200px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">Laminated Glass</h6>
                    <p class="card-text flex-grow-1">Laminated glass is a multi-functional glazing material that can be used in a variety of applications. It is manufactured by permanently bonding two or more glass panes with layers of polyvinyl butyral (PVB) interlayer, under heat and pressure to produce a single product.</p>
                    @if ($my_user != null)
                    <a href="/get-quotation-glassprocessing" class="btn btn-danger mt-auto get-quotation-button w-100">Get Quotation</a>
                    @else
                    <a href="#" class="btn btn-danger mt-auto get-quotation-button w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 d-flex align-items-stretch">
            <div class="card border-0 shadow-sm d-flex flex-column">
                <img src="{{ asset('storage/glass-processing/curved.jpg') }}" alt="TQMP Curved Glass" class="card-img-top" style="object-fit: cover; width: 100%; height: 200px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">Curved Tempered Glass</h6>
                    <p class="card-text flex-grow-1">In the same manner with flat tempered glass, curved tempered glass is also resistant to mechanical stresses (bending, impact, etc.) and thermal stresses (temperature difference), without altering the properties of the basic product.</p>
                    @if ($my_user != null)
                    <a href="/get-quotation-glassprocessing" class="btn btn-danger mt-auto get-quotation-button w-100">Get Quotation</a>
                    @else
                    <a href="#" class="btn btn-danger mt-auto get-quotation-button w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4 d-flex align-items-stretch">
            <div class="card border-0 shadow-sm d-flex flex-column">
                <img src="{{ asset('storage/glass-processing/igu.png') }}" alt="TQMP IGU" class="card-img-top" style="object-fit: cover; width: 100%; height: 200px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                <div class="card-body d-flex flex-column">
                    <h6 class="fw-bold">Insulating Glass Unit (IGU)</h6>
                    <p class="card-text flex-grow-1">Insulating glass unit is a set of two or more lites of glass separated by air space and hermetically sealed to form a single unit. Its most important function is to improve the thermal performance of glass when used in architectural applications.</p>
                    @if ($my_user != null)
                    <a href="/get-quotation-glassprocessing" class="btn btn-danger mt-auto get-quotation-button w-100">Get Quotation</a>
                    @else
                    <a href="#" class="btn btn-danger mt-auto get-quotation-button w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                    @endif
                </div>
            </div>
        </div> --}}
        </div>
    </section>
    {{-- <!-- @include ('plus.cta') --> --}}
    @include ('plus.accordion')
    @include ('plus.chatbot')
    @include ('plus.footer')
    @include ('plus.scripts').
</body>

</html>
