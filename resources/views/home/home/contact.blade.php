<!DOCTYPE html>
<html lang="en">

<head>
    @include ('plus.head')
</head>

<body>
    @include('plus.navbar')
    <section id="landing-contact" class="hero-wrapper fade-in-up">
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
            <h2 class="fw-bold fs-2">Reach us for inquiries</h2>

            Have questions or need assistance? Fill out the form below, and our team will get back to you promptly.

        </div>
    </section>

    {{-- <!-- <section id="title">
        <div class="container text-center py-5 fade-in-up">
            <span class="badge text-white mb-2" style="background-color: #950101; font-size:large;">Contact Us</span>
            <h2 class="fw-bold">Reach us for inquiries</h2>
            <p class="mt-3">
                Have questions or need assistance? Fill out the form below, and our team will get back to you promptly.
            </p>
        </div>
    </section> --> --}}

    <section id="form" class="fade-in-up container py-3 mt-3">
        <div class="col-md-12">
            <h3 class="fw-bold">Fill out the form</h3>
            <form class="py-3" action="/inquiry-store" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="fullName" class="form-label fw-bold">Full Name <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fullName" name="fullname"
                        placeholder="Your full name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Your email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold">Phone Number <span
                            class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="phone" name="contact_num"
                        placeholder="Your phone number">
                </div>
                <div class="mb-3">
                    <label for="subject" class="form-label fw-bold">Subject <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label fw-bold">Message <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="message" name="message" rows="5" placeholder="Write your message here"></textarea>
                </div>
                <div class="mb-3">
                    <label for="formFileSm" class="form-label fw-bold">Please upload your government ID and/or Business
                        Registration if you're a business owner. Be Our Partner to enjoy our Best Price Offers. <span
                            class="text-danger">*</span></label>
                    <input class="form-control form-control-sm" name="upload_file" id="formFileSm" type="file">
                </div>
                <div>
                    <button type="submit" class="card-button btn btn-danger mt-auto btn-block w-100 mb-3">Send
                        Message</button>
                </div>
            </form>
        </div>
    </section>
    <section id="locations" class="fade-in-up container">
        <div class="container contact-section py-5 mt-3">
            <div class="row">
                <div class="col-md-6 mt-3">
                    <div class="mb-4">
                        <h3 class="fw-bold ">Get in Touch</h3><br>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <h5><i class="fas fa-envelope text-danger me-2"></i> Email</h5>
                                <p class="text-muted mb-0">Get in touch with us</p>
                                <p><b>{{ $settings['CONTACT_EMAIL'] }}</b></p>
                            </div>
                            <div class="col-md-4">
                                <h5><i class="fas fa-clock text-danger me-2"></i> Business Hours</h5>
                                <p class="text-muted mb-0">Check out our Business Hours</p>
                                {!! $settings['CONTACT_BUSINESS_HOURS'] !!}
                            </div>
                        </div>
                    </div>
                    <div class="mb-4 contact-info">
                        <h3 class="fw-bold ">Locations</h3><br>
                        <div class="mb-3">
                            <h5><i class="fas fa-map-marker-alt text-danger me-2"></i> Main Office</h5>
                            {!! $settings['CONTACT_MAIN_OFFICE'] !!}
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5><i class="fas fa-map-marker-alt text-danger me-2"></i> Luzon Offices</h5>
                                    {!! $settings['CONTACT_LUZON_OFFICE1'] !!}
                                    {!! $settings['CONTACT_LUZON_OFFICE2'] !!}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <h5><i class="fas fa-map-marker-alt text-danger me-2"></i> Visayas Offices</h5>
                                    {!! $settings['CONTACT_VISAYAS_OFFICE1'] !!}
                                    {!! $settings['CONTACT_VISAYAS_OFFICE2'] !!}
                                </div>
                                <div class="mb-3">
                                    <h5><i class="fas fa-map-marker-alt text-danger me-2"></i> Mindanao Offices</h5>
                                    {!! $settings['CONTACT_MINDANAO_OFFICE1'] !!}
                                    {!! $settings['CONTACT_MINDANAO_OFFICE2'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <h3 class="fw-bold">Office Locations Nationwide</h3>
                    <div class="mt-4"
                        style="box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden;">
                        <iframe width="100%" height="610" frameborder="0" style="border: 0; border-radius: 8px;"
                            referrerpolicy="no-referrer-when-downgrade"
                            src="https://www.google.com/maps/d/u/1/embed?mid=1T_rIsKAGT3S3DoiTe2Kxj2Gc0eoeVQQ&ehbc=2E312F&noprof=1&z=5&output=embed"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include ('plus.scripts')
    {{-- <!-- <!-- @include ('plus.cta') --> --> --}}
    @include ('plus.accordion')
    @include('plus.chatbot')
    @include ('plus.footer')
    @if (session()->has('error_msg'))
        <script>
            toastr.options.preventDuplicates = true;
            toastr.error("{{ session('error_msg') }}");
        </script>
    @endif
    @error('code')
        <script>
            toastr.options.preventDuplicates = true;
            toastr.error('Code already exists');
        </script>
    @enderror
    @if (session()->has('success_msg'))
        <script>
            toastr.options.preventDuplicates = true;
            toastr.success("{{ session('success_msg') }}");
        </script>
    @endif
    @if (session()->has('download_file'))
        <script>
            $("#download_filename").val("{{ session('download_file') }}");
            $("#downloadForm").submit();
        </script>
    @endif
</body>

</html>
