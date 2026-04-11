<!doctype html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')
    <section>
        <div class="container py-4">
            <div class="container faq-section">
                <div class="container text-center">
                    <span class="badge text-white mb-2" style="background-color: #950101;">FAQs</span>
                    <h2 class="fw-bold">Any Questions? Look Here</h2>
                    <p class="text-muted">
                        We have sorted out your frequently asked questions. You can select the one that best meets your needs by clicking below.
                    </p>
                </div>
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                Can you produce or process this?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, we can. Kindly attach the Drawing in order for our Processing Department to assess and analyze your requirement/ sample.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                What is the ideal thickness for?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Depending on the application or use, for example, a primary door with 12mm glass for a frameless or patch door may use 6mm or 8mm, depending on the aluminum profile frame being used.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                What is the ideal size for?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                It depends on where you plan to use or apply it. For example, the main door height will be between 2.1 and 2.4 meters and width between 0.9 and 1.0 meters.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                What is the price of?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                The pricing may vary or change depending on the day you received the quotation.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                Do you have this item?
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Please attach a clear picture to make item verification easier.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                What is your delivery date commitment?
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="faq6"
                            data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                When you order our products, we can send it right away. You can pick from a variety of couriers or even pick it up right away. The quantity of your order will determine how long it takes to process or produce.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include ('plus.scripts')
    <!-- @include ('plus.cta') -->
    @include ('plus.accordion')
    @include('plus.chatbot')
    @include ('plus.footer')
</body>
</html>