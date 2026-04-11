<!DOCTYPE html>
<html lang="en">

<head>
    @include('plus.head')
</head>

<body>
    @include('plus.navbar')
    <section id="hero" class="hero section dark-background fade-in-up" style="background: url('storage/home/{{ $settings['HOME_BANNER_IMAGE'] }}') no-repeat center center/cover;">
        <!-- <div class="container">
            <div class="row justify-content-center text-center text-light">
                <div class="col-xl-9 col-lg-8">
                    <h2 class="word-fade-in landing-text sub-heading" style="color: #e53935;">
                        @php
                        // Split the title into an array of words
                        $words = explode(' ', strip_tags($settings['HOME_BANNER_TITLE']));
                        @endphp

                        @foreach($words as $index => $word)
                        <span class="animated-word" style="animation-delay: {{ ($index + 1) * 0.1 }}s">
                            <span class="word-outline">{{ $word }}</span>
                            <span class="word-fill">{{ $word }}</span>
                        </span>
                        @endforeach
                    </h2>
                    @if($my_user == null)
                    <div class="text-center mb-5 mt-3 fade-in">
                        <a class="btn btn-danger px-4 py-2" href="/about" target="_blank">
                            Learn More
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div> -->
    </section>

    <section id="services" class="py-5 mt-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Our Products and Services</h2>
                <p>
                    Committed to providing superior products and services that uphold the highest industry benchmarks.
                    Our advanced techniques and state-of-the-art equipment ensure that every project is completed with precision and excellence.
                </p>
            </div>
            <div class="row">

                <!-- Aluminum Manufacturing -->
                <div class="col-md-4 py-3">
                    <a href="/aluminummanufacturing" class="text-decoration-none">
                        <div class="card-overlay shadow-sm">
                            <img src="{{ asset('storage/home/'.$settings['HOME_SHOPBY_ALUMINUM_IMAGE']) }}">
                            <!-- <div class="card-overlay-content">
                                <h5 class="services-title">
                                    <span>ALUMINUM MANUFACTURING</span>
                                </h5>
                                <p class="services-desc">{{ $settings['HOME_SHOPBY_ALUMINUM_TEXT'] }}</p>
                            </div> -->

                            <div class="card-overlay-content">
                                <svg class="outlined-text" viewBox="0 0 1000 200" preserveAspectRatio="xMidYMid meet">
                                    <text x="1%" y="55%" dominant-baseline="middle">
                                        ALUMINUM MANUFACTURING
                                    </text>
                                </svg>
                                <p>{{ $settings['HOME_SHOPBY_ALUMINUM_TEXT'] }}</p>
                            </div>

                        </div>
                    </a>
                </div>

                <!-- Armoured Vehicles -->
                <div class="col-md-4 py-3">
                    <a href="/bulletproofing" class="text-decoration-none">
                        <div class="card-overlay shadow-sm">
                            <img src="{{ asset('storage/home/'.$settings['HOME_OFFER_BULLET_IMAGE']) }}">
                            <div class="card-overlay-content">
                                <svg class="outlined-text" viewBox="0 0 1000 200" preserveAspectRatio="xMidYMid meet">
                                    <text x="1%" y="55%" dominant-baseline="middle">
                                        BULLETPROOFING
                                    </text>
                                </svg>
                                <p>{{ $settings['HOME_OFFER_BULLET_TEXT'] }}</p>
                                <!-- <span>Read More</span> -->
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Glass Manufacturing -->
                <div class="col-md-4 py-3">
                    <a href="/glassmanufacturing" class="text-decoration-none">
                        <div class="card-overlay shadow-sm">
                            <img src="{{ asset('storage/home/'.$settings['HOME_SHOPBY_GLASS_IMAGE']) }}">
                            <div class="card-overlay-content">
                                <svg class="outlined-text" viewBox="0 0 1000 200" preserveAspectRatio="xMidYMid meet">
                                    <text x="1%" y="55%" dominant-baseline="middle">
                                        GLASS MANUFACTURING
                                    </text>
                                </svg>
                                <p>{{ $settings['HOME_SHOPBY_GLASS_TEXT'] }}</p>
                                <!-- <span>Read More</span> -->
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Glass Processing -->
                <div class="col-md-4 py-3">
                    <a href="/glassprocessing" class="text-decoration-none">
                        <div class="card-overlay shadow-sm">
                            <img src="{{ asset('storage/glass-processing/'.$settings['HOME_OFFER_GLASS_IMAGE']) }}">
                            <div class="card-overlay-content">
                                <svg class="outlined-text" viewBox="0 0 1000 200" preserveAspectRatio="xMidYMid meet">
                                    <text x="1%" y="55%" dominant-baseline="middle">
                                        GLASS PROCESSING
                                    </text>
                                </svg>
                                <p>{{ $settings['HOME_OFFER_GLASS_TEXT'] }}</p>
                                <!-- <span>Read More</span> -->
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Architectural Hardware -->
                <div class="col-md-4 py-3">
                    <a href="/gentrade" class="text-decoration-none">
                        <div class="card-overlay shadow-sm">
                            <img src="{{ asset('storage/home/'.$settings['HOME_SHOPBY_OTHERS_IMAGE']) }}">
                            <div class="card-overlay-content">
                                <svg class="outlined-text" viewBox="0 0 1000 200" preserveAspectRatio="xMidYMid meet">
                                    <text x="1%" y="55%" dominant-baseline="middle">
                                        ARCHITECTURAL HARDWARE
                                    </text>
                                </svg>
                                <p>{{ $settings['HOME_SHOPBY_OTHERS_TEXT'] }}</p>
                                <!-- <span>Read More</span> -->
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Other Products -->
                <div class="col-md-4 py-3">
                    <a href="/shop" class="text-decoration-none">
                        <div class="card-overlay shadow-sm">
                            <img src="{{ asset('storage/home/'.$settings['HOME_SHOPBY_OTHERS_IMAGE']) }}">
                            <div class="card-overlay-content">
                                <svg class="outlined-text" viewBox="0 0 1000 200" preserveAspectRatio="xMidYMid meet">
                                    <text x="1%" y="55%" dominant-baseline="middle">
                                        OTHER PRODUCTS & SERVICES
                                    </text>
                                </svg>
                                <p>{{ $settings['HOME_SHOPBY_OTHERS_TEXT'] }}</p>
                                <!-- <span>Read More</span> -->
                            </div>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </section>

    @include ('plus.scripts')
    @if($my_user == null)
    @include ('plus.cta')
    @endif
    @include ('plus.accordion')
    @include ('plus.logos')
    @include ('plus.chatbot')
    @include ('plus.footer')
</body>

</html>