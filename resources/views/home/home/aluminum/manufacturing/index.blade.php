<!DOCTYPE html>
<html lang="en">

<head>
    @include ('plus.head')
</head>

<body>
    @include('plus.navbar')
    <section id="landing-aluminum-profile" class="hero-wrapper fade-in-up">
        <!-- IMAGE BANNER -->
        <div class="hero-banner"
            style="background-image: url('storage/aluminum/{{ $settings['ALUMINUM_MFG_BANNER_IMAGE'] }}');">
        </div>

        <!-- OVERLAPPING LOGO -->
        <div class="hero-logo">
            <img src="{{ asset('storage/logos/hsp-logo.gif') }}" alt="Logo">
        </div>

        <!-- WHITE CONTENT -->
        <div class="container text-center hero-content">
            <h2 class="fw-bold fs-2">Aluminum Manufacturing</h2>

            {!! $settings['ALUMINUM_MFG_BANNER_DESC'] !!} <br><br>

            <a href="/about" target="_blank"
                class="btn btn-danger px-4 py-2">
                Find out more
            </a>
        </div>
    </section>
 {{-- <section id="landing-aluminum-profile" class="d-flex align-items-center justify-content-center text-center min-vh-100"
        style="background: linear-gradient(rgba(23, 38, 71, 0.3), rgba(126, 20, 22, 0.4)),
                    url('storage/aluminum/{{ $settings['ALUMINUM_MFG_BANNER_IMAGE'] }}') no-repeat center center/cover;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                {!! $settings['ALUMINUM_MFG_BANNER_TITLE'] !!}
                {!! $settings['ALUMINUM_MFG_BANNER_DESC'] !!}
                <div class="d-flex align-items-center justify-content-center">
                    <a href="https://www.facebook.com/profile.php?id=100093168407108" class="card-button btn btn-light fade-in text-decoration-none" style="font-size: smaller;">
                        <span>Find out more</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </section>  --}}
    
    <section id="about-aluminum-profiles" class="fade-in-up">
        <div class="container py-5">
            <div class="row">
                {{-- <!-- <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('storage/aluminum/'. $settings['ALUMINUM_MFG_ABOUT_US_IMAGE']) }}" alt="Bullet Proofing" class="img-fluid rounded-lg" style="padding: 20px;">
                </div> --> --}}
                <div class="col-lg-12">
                    <div class="card-body py-5">
                        <h2 class="fw-bold">About us</h2>
                        {!! $settings['ALUMINUM_MFG_ABOUT_US_DESC'] !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="services-aluminum-profiles" class="py-5 fade-in-up">
        <div class="container">
            <div class="container">
                <div class="text-center">
                    <h2 class="fw-bold">Aluminum Profiles</h2>
                    <div class="container mt-4">
                        <div class="d-flex justify-content-between align-items-start flex-wrap text-center">
                            <div style="flex: 1;">
                                <div class="fw-bold text-dark">Step 1</div>
                                <div style="height: 6px; background-color: #65000B; margin-top: 4px;"></div>
                                <div class="text-muted small mt-2">Raw Material Procurement</div>
                            </div>
                            <div style="flex: 1;">
                                <div class="fw-bold text-secondary">Step 2</div>
                                <div style="height: 4px; background-color: lightgray; margin-top: 4px;"></div>
                                <div class="text-muted small mt-2">Mold Design & Processing</div>
                            </div>
                            <div style="flex: 1;">
                                <div class="fw-bold text-secondary">Step 3</div>
                                <div style="height: 4px; background-color: lightgray; margin-top: 4px;"></div>
                                <div class="text-muted small mt-2">Extrusion Processing</div>
                            </div>
                            <div style="flex: 1;">
                                <div class="fw-bold text-secondary">Step 4</div>
                                <div style="height: 4px; background-color: lightgray; margin-top: 4px;"></div>
                                <div class="text-muted small mt-2">Quality Inspection</div>
                            </div>
                            <div style="flex: 1;">
                                <div class="fw-bold text-secondary">Step 5</div>
                                <div style="height: 4px; background-color: lightgray; margin-top: 4px;"></div>
                                <div class="text-muted small mt-2">Finished Product Packaging</div>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                class Profile{
                public $title;
                public $image;

                public function __construct($title, $image) {
                $this->title = $title;
                $this->image = $image;
                }
                }

                $profiles = [];

                $count = $settings_raw->filter(fn($item) => str_contains($item->key, 'ALUMINUM_MFG_PROFILE'))->count();
                $count = $count / 2; // Each product has 2 fields: title, image
                $itemsPerPage = 3; // Number of products per page

                for ($i = 1; $i <= $count; $i++) {
                    $title=$settings['ALUMINUM_MFG_PROFILE_TITLE' . $i];
                    $image=$settings['ALUMINUM_MFG_PROFILE_IMAGE' . $i];
                    array_push($profiles, new Profile($title, $image));
                    }

                    @endphp

                    <div class="container mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="tab-content" id="pagination-content">

                                @foreach($profiles as $profile)

                                @if($loop->index % $itemsPerPage == 0)
                                <div class="tab-pane fade @if($loop->index == 0) show active @endif" id="page-{{ intdiv($loop->index + 1, $itemsPerPage) }}" role="tabpanel" aria-labelledby="page-{{ intdiv($loop->index + 1, $itemsPerPage) }}-tab">
                                    <div class="container mt-2">
                                        <div class="row py-3 g-3">
                                            @endif
                                            <div class="col-12 col-md-4 d-flex align-items-stretch">
                                                <div class="card border-1 d-flex flex-column w-100">
                                                    <img src="{{ asset('storage/aluminum/'.$profile->image) }}"
                                                        onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                                        alt="TQMP {{ $profile->title }}"
                                                        class="card-img-top"
                                                        style="object-fit: contain; width: 100%; height: 400px; background: #fff; border-radius:8px 8px 0 0;">
                                                    <div class="card-body d-flex flex-column">
                                                        <h6 class="card-title text-start fw-bold">{{ $profile->title }}</h6>
                                                        @if($my_user != null)
                                                        <a href="/shop" class="btn btn-danger mt-auto w-100">Get Quotation</a>
                                                        @else
                                                        <a href="#" class="btn btn-danger mt-auto w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if($loop->index % $itemsPerPage == 2 || $loop->index == count($profiles) - 1)
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @endforeach

                                {{-- <div class="tab-pane fade show active" id="page-1" role="tabpanel" aria-labelledby="page-1-tab">
                                    <div class="container mt-2">
                                        <div class="row py-3 g-3">
                                            @foreach([
                                            ['01.jpg','Angle Sections'],
                                            ['02.jpg','Storefront Components'],
                                            ['03.jpg','Storefront Components']
                                            ] as $item)
                                            <div class="col-12 col-md-4 d-flex align-items-stretch">
                                                <div class="card border-1 d-flex flex-column w-100">
                                                    <img src="{{ asset('storage/aluminum/'.$item[0]) }}"
                                onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                alt="TQMP {{ $item[1] }}"
                                class="card-img-top"
                                style="object-fit: contain; width: 100%; height: 400px; background: #fff; border-radius:8px 8px 0 0;">
                                <div class="card-body d-flex flex-column">
                                    <h6 class="card-title text-start fw-bold">{{ $item[1] }}</h6>
                                    @if($my_user != null)
                                    <a href="/shop" class="btn btn-danger mt-auto w-100">Get Quotation</a>
                                    @else
                                    <a href="#" class="btn btn-danger mt-auto w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
            </div>
        </div>
        <div class="tab-pane fade" id="page-2" role="tabpanel" aria-labelledby="page-2-tab">
            <div class="container mt-2">
                <div class="row py-3 g-3">
                    @foreach([
                    ['04.jpg','Storefront Components'],
                    ['05.jpg','Storefront Components'],
                    ['06.jpg','Screen Door and Windows']
                    ] as $item)
                    <div class="col-12 col-md-4 d-flex align-items-stretch">
                        <div class="card border-1 d-flex flex-column w-100">
                            <img src="{{ asset('storage/aluminum/'.$item[0]) }}"
                                onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                alt="TQMP {{ $item[1] }}"
                                class="card-img-top"
                                style="object-fit: contain; width: 100%; height: 400px; background: #fff; border-radius:8px 8px 0 0;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title text-start fw-bold">{{ $item[1] }}</h6>
                                @if($my_user != null)
                                <a href="/shop" class="btn btn-danger mt-auto w-100">Get Quotation</a>
                                @else
                                <a href="#" class="btn btn-danger mt-auto w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="page-3" role="tabpanel" aria-labelledby="page-3-tab">
            <div class="container mt-2">
                <div class="row py-3 g-3">
                    @foreach([
                    ['07.jpg','Sliding Door Sections'],
                    ['08.jpg','Sliding Door Sections'],
                    ['09.jpg','Sliding Door Sections']
                    ] as $item)
                    <div class="col-12 col-md-4 d-flex align-items-stretch">
                        <div class="card border-1 d-flex flex-column w-100">
                            <img src="{{ asset('storage/aluminum/'.$item[0]) }}"
                                onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                alt="TQMP {{ $item[1] }}"
                                class="card-img-top"
                                style="object-fit: contain; width: 100%; height: 400px; background: #fff; border-radius:8px 8px 0 0;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title text-start fw-bold">{{ $item[1] }}</h6>
                                @if($my_user != null)
                                <a href="/shop" class="btn btn-danger mt-auto w-100">Get Quotation</a>
                                @else
                                <a href="#" class="btn btn-danger mt-auto w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="page-4" role="tabpanel" aria-labelledby="page-4-tab">
            <div class="container mt-2">
                <div class="row py-3 g-3">
                    @foreach([
                    ['10.jpg','Sliding Door Sections'],
                    ['11.jpg','Miscellaneous Sections'],
                    ['12.jpg','Swing Door Sections']
                    ] as $item)
                    <div class="col-12 col-md-4 d-flex align-items-stretch">
                        <div class="card border-1 d-flex flex-column w-100">
                            <img src="{{ asset('storage/aluminum/'.$item[0]) }}"
                                onerror="this.onerror=null; this.src='{{ asset('storage/all-items/default-product-image.png') }}';"
                                alt="TQMP {{ $item[1] }}"
                                class="card-img-top"
                                style="object-fit: contain; width: 100%; height: 400px; background: #fff; border-radius:8px 8px 0 0;">
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title text-start fw-bold">{{ $item[1] }}</h6>
                                @if($my_user != null)
                                <a href="/shop" class="btn btn-danger mt-auto w-100">Get Quotation</a>
                                @else
                                <a href="#" class="btn btn-danger mt-auto w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Get Quotation</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> --}}


        </div>

        </div>
        </div>


        <div class="row mt-4 px-md-5 px-3">
            <div class="col-12">
                <ul class="nav nav-pills justify-content-center flex-row flex-sm-row">
                    @for($i = 1; $i <= intdiv(count($profiles) + 1, $itemsPerPage); $i++)
                        <li class="nav-item" role="presentation">
                        <button class="nav-link px-3 py-2 fs-6 @if($i == 1) active @endif" id="page-{{ $i - 1 }}-tab"
                            data-bs-toggle="pill" data-bs-target="#page-{{ $i - 1 }}" type="button" role="tab"
                            aria-controls="page-{{ $i - 1 }}" aria-selected=" @if($i == 1) true @else false @endif">{{ $i }}</button>
                        </li>
                        @endfor
                </ul>
            </div>
        </div>

        </div>
        </div>
        </div>
    </section>
    {{-- <!-- @include ('plus.cta') --> --}}
    @include ('plus.accordion')
    @include ('plus.chatbot')
    @include ('plus.footer')
    @include ('plus.scripts')
</body>

</html>