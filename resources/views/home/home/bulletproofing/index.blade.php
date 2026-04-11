<!DOCTYPE html>
<html lang="en">
@include ('plus.head')

<body>
    @include('plus.navbar')
    <section id="landing-bulletproofing" class="hero-wrapper fade-in-up">
        <!-- IMAGE BANNER -->
        <div class="hero-banner"
            style="background-image: url('{{ asset('storage/bulletproofing/' . $settings['BULLET_BANNER_IMAGE']) }}');">
        </div>

        <!-- OVERLAPPING LOGO -->
        <div class="hero-logo">
            <img src="{{ asset('storage/logos/master-logo.gif') }}" alt="Logo">
        </div>

        <!-- WHITE CONTENT -->
        <div class="container text-center hero-content">
            <h2 class="fw-bold fs-2">Master Armoured Vehicle</h2>

            {!! $settings['BULLET_BANNER_DESC'] !!} <br><br>

            <a href="https://www.facebook.com/people/Master-Armoured-Vehicle/61561429240605/" target="_blank"
                class="btn btn-danger px-4">
                Find out more
            </a>
        </div>
    </section>

    <section id="about-bulletproofing" class="fade-in-up">
        <div class="container py-5">
            <div class="row">
                {{-- <!-- <div class="col-lg-6 d-flex justify-content-center align-items-center">
                    <img src="{{ asset('storage/bulletproofing/' . $settings['BULLET_ABOUT_US_IMAGE']) }}" alt="Bullet Proofing" class="img-fluid rounded-lg" style="padding: 20px;">
            </div> --> --}}
                <div class="col-lg-12">
                    <div class="card-body py-5">
                        <h2 class="fw-bold">About us</h2>
                        {!! $settings['BULLET_ABOUT_US_DESC'] !!}
                    </div>
                </div>
            </div>
        </div>

    </section>
    <section id="benefits-bulletproofing">
        <div class="container py-5 fade-in-up">
            <div class="row">
                <div class="col-lg-7">
                    <div class="our-story">
                        <h2 class="fw-bold">Benefits and key advantages of bulletproofing your vehicle</h2>
                        {!! $settings['BULLET_BENEFITS_DESC'] !!}
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class=" d-flex justify-content-center align-items-center h-100">
                        <video controls class="img-fluid rounded-lg hover-video" muted loop
                            style="padding: 10px; max-width: 100%;">
                            <source src="{{ asset('storage/bulletproofing/' . $settings['BULLET_BENEFITS_VID']) }}"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="services-bulletproofing" class="container fade-in-up">
        <div class="container mt-5 text-center">
            <h2 class="fw-bold">Bullet Proofing Services</h2>
            <p class="text-muted">
                The following are the services offered under bullet proof manufacturing
            </p>
        </div>
        <div class="row mt-5">

            @foreach ($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card border-0 shadow-sm">
                        <img src="{{ asset('storage/all-items/' . $product->filename) }}"
                            alt="{{ $product->display_name }}"
                            style="object-fit: cover; width: 100%; height: 200px; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                        <div class="card-body">
                            <h6 class="fw-bold">{{ $product->display_name }}</h6>
                            <p class="card-text">{{ $product->description }}</p>
                            @if ($my_user != null)
                                <a href="/get-quotation-bulletproofing" class="btn btn-danger w-100">Get Quotation</a>
                            @else
                                <a href="/#" class="btn btn-danger w-100" data-bs-toggle="modal"
                                    data-bs-target="#loginModal">Get Quotation</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>
    <section id="videos-bulletproofing" class="container fade-in mt-5">
        <div class="container mt-5 text-center">
            <h2 class="fw-bold">Videos</h2>
            <p class="text-muted">
                Here are some of our videos related to bullet proofing. You may take a look.
            </p>
        </div>
        <div class="container row">
            <div class="col-md-6 d-flex align-items-stretch">
                <div class="p-3 w-100 d-flex flex-column align-items-center">
                    <div class="ratio ratio-16x9" style="width: 100%; max-width: 100%; height: 400px;">
                        <video controls class="img-fluid rounded-lg hover-video" muted loop
                            style="object-fit: cover; width: 100%; height: 100%;">
                            <source src="{{ asset('storage/bulletproofing/' . $settings['BULLET_VIDEOS_VID1']) }}"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="card-body text-center mt-3">
                        <h5>{{ $settings['BULLET_VIDEOS_TITLE1'] }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-stretch py-3 py-md-0">
                <div class="p-3 w-100 d-flex flex-column align-items-center">
                    <div class="ratio ratio-16x9" style="width: 100%; max-width: 100%; height: 400px;">
                        <video controls class="img-fluid rounded-lg hover-video" muted loop
                            style="object-fit: cover; width: 100%; height: 100%;">
                            <source src="{{ asset('storage/bulletproofing/' . $settings['BULLET_VIDEOS_VID2']) }}"
                                type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="card-body text-center mt-3">
                        <h5>{{ $settings['BULLET_VIDEOS_TITLE2'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="faqs-bulletproofing">
        <section class="py-3 mt-5">
            <div class="container text-center">
                <h2 class="fw-bold">Frequently Asked Questions</h2>
                <p class="text-muted">
                    We have sorted out your frequently asked questions. You can select the one that best meets your
                    needs by clicking below.
                </p>
            </div>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="accordion accordion-flush" id="faqAccordionLeft">
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne"
                                        style="color: #000;">
                                        <h6 class="fw-bold">What types of vehicles can be bulletproofed?</h6>
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                    data-bs-parent="#faqAccordionLeft">
                                    <div class="accordion-body" style="color: #6c757d;">
                                        Any cars can be armoured.
                                        <br>1.1 SUV
                                        <br>1.2 Pick-up
                                        <br>1.3 Van
                                        <br>1.4 Heavy Equipment
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                        aria-controls="collapseTwo" style="color: #000;">
                                        <h6 class="fw-bold">How does bulletproofing affect the vehicle's performance?
                                        </h6>
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="headingTwo" data-bs-parent="#faqAccordionLeft">
                                    <div class="accordion-body" style="color: #6c757d;">
                                        Bulletproofing increases the weight of the vehicle due to the ballistic plates
                                        and bullet resistant glass (BRG).
                                        Thus, changes in acceleration, maneuverability, braking, and, fuel efficiency
                                        maybe experienced.
                                        The driver must be mindful of these changes to ensure safe and optimal vehicle
                                        driving.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                        aria-expanded="false" aria-controls="collapseThree" style="color: #000;">
                                        <h6 class="fw-bold">Can bulletproofing be customized to maintain the car's
                                            appearance?</h6>
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#faqAccordionLeft">
                                    <div class="accordion-body" style="color: #6c757d;">
                                        Bulletproofing is generally customized to meet specific needs in terms of
                                        protection level, while maintaining the car's appearance, luxury, and style.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingFour">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                        aria-expanded="false" aria-controls="collapseFour" style="color: #000;">
                                        <h6 class="fw-bold">How long does the bulletproofing process take?</h6>
                                    </button>
                                </h2>
                                <div id="collapseFour" class="accordion-collapse collapse"
                                    aria-labelledby="headingFour" data-bs-parent="#faqAccordionLeft">
                                    <div class="accordion-body" style="color: #6c757d;">
                                        Bulletproofing process can take from few weeks up to several months, depending
                                        on the complexity or armoring level package selected by the customer.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="accordion accordion-flush" id="faqAccordionRight">
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingFive">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                        aria-expanded="false" aria-controls="collapseFive" style="color: #000;">
                                        <h6 class="fw-bold">What is light-weight armor?</h6>
                                    </button>
                                </h2>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    aria-labelledby="headingFive" data-bs-parent="#faqAccordionRight">
                                    <div class="accordion-body" style="color: #6c757d;">
                                        Light weight armor offers effective protection while being easier to wear for
                                        extended periods.
                                        Made from advanced materials, it balances safety and comport, allowing for
                                        greater mobility without the bulk of traditional armor.
                                        This makes it ideal for both personal and professional use.
                                        Lightweight armor start from BR level 4 and lower.
                                        It offers effective protection while being easier to wear for extended periods.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingSix">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false"
                                        aria-controls="collapseSix" style="color: #000;">
                                        <h6 class="fw-bold">Is bulletproofing a permanent modification?</h6>
                                    </button>
                                </h2>
                                <div id="collapseSix" class="accordion-collapse collapse"
                                    aria-labelledby="headingSix" data-bs-parent="#faqAccordionRight">
                                    <div class="accordion-body" style="color: #6c757d;">
                                        It is a complete process of making a vehicle robust to stay intact in bad
                                        circumstances.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingSeven">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseSeven"
                                        aria-expanded="false" aria-controls="collapseSeven" style="color: #000;">
                                        <h6 class="fw-bold">How much does bulletproofing cost?</h6>
                                    </button>
                                </h2>
                                <div id="collapseSeven" class="accordion-collapse collapse"
                                    aria-labelledby="headingSeven" data-bs-parent="#faqAccordionRight">
                                    <div class="accordion-body" style="color: #6c757d;">
                                        The cost of bulletproofing varies based on the specific customization needs of
                                        each client.
                                        Factors such as the level of ballistic protection, materials used, and design
                                        complexities all influence the final pricing.
                                        Therefore, each bulletproofing project is priced individually.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingEight">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseEight"
                                        aria-expanded="false" aria-controls="collapseEight" style="color: #000;">
                                        <h6 class="fw-bold">Any maintenance requirements after bulletproofing?</h6>
                                    </button>
                                </h2>
                                <div id="collapseEight" class="accordion-collapse collapse"
                                    aria-labelledby="headingEight" data-bs-parent="#faqAccordionRight">
                                    <div class="accordion-body" style="color: #6c757d;">
                                        Maintaining a fully armoured vehicle is vital.
                                        Regular cleaning, tire care, mechanical inspections and armoured upgraded parts
                                        check can ensure the optimal functionality and protection of armoured car.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    @include ('plus.scripts')
    @include('plus.chatbot')
    @include ('plus.footer')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hoverVideo = document.querySelectorAll('.hover-video');
            hoverVideo.forEach(video => {
                video.addEventListener('mouseenter', function() {
                    video.play();
                });
                video.addEventListener('mouseleave', function() {
                    video.pause();
                });
            });
        });
    </script>
</body>

</html>
