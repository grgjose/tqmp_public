<!DOCTYPE html>
<html lang="en">

<head>
    @include('plus.head')

</head>

<body>
    @include('plus.navbar')
    <section id="landing-about" class="hero-wrapper fade-in-up">
        <!-- IMAGE BANNER -->
        <div class="hero-banner"
            style="background-image: url('storage/about-us/{{ $settings['ABOUT_US_BANNER_IMAGE'] }}');">
        </div>

        <!-- OVERLAPPING LOGO -->
        <div class="hero-logo">
            <img src="{{ asset('storage/logos/TQMPLogo.png') }}" alt="Logo">
        </div>

        <!-- WHITE CONTENT -->
        <div class="container text-center hero-content">
            <h2 class="fw-bold fs-2 text-danger">About</h2>

            {!! $settings['ABOUT_US_BANNER_DESC'] !!} <br><br>

        </div>
    </section>

    {{-- <section id="">
        <div class="dark-background text-light" style="background: url('storage/about-us/{{ $settings['ABOUT_US_BANNER_IMAGE'] }}') center/cover no-repeat, rgba(0, 0, 0, 0.4); background-blend-mode: overlay; padding: 160px 0 60px 0; text-align: center; position: relative;">
            <div class="container fade-in-up py-5">
                {!! $settings['ABOUT_US_BANNER_TITLE'] !!}
                {!! $settings['ABOUT_US_BANNER_DESC'] !!}
            </div>
        </div>
    </section> --}}

    <section id="timeline-company">
        <div class="container py-5">
            <div class="container text-center fade-in-up">
                <span class="badge text-white mb-2" style="background-color: #950101; font-size:large;">Timeline</span>
            </div>
            <div id="timeline" class="container fade-in-up">
                <div class="section section-md">
                    <div class="container">
                        <div class="row mt-4 justify-content-center">
                            <div class="col-md-10 mx-auto">
                                <div>

                                    @php
                                        class Timeline
                                        {
                                            public $year;
                                            public $image;
                                            public $description;

                                            public function __construct($year, $image, $description)
                                            {
                                                $this->year = $year;
                                                $this->image = $image;
                                                $this->description = $description;
                                            }
                                        }

                                        $timelines = [];

                                        $count = $settings_raw
                                            ->filter(fn($item) => str_contains($item->key, 'ABOUT_US_TIMELINE_'))
                                            ->count();
                                        $count = $count / 3; // Each product has 3 fields: year, image, description

                                        for ($i = 1; $i <= $count; $i++) {
                                            $year = $settings['ABOUT_US_TIMELINE_YEAR' . $i];
                                            $image = $settings['ABOUT_US_TIMELINE_IMAGE' . $i];
                                            $description = $settings['ABOUT_US_TIMELINE_DESC' . $i];
                                            array_push($timelines, new Timeline($year, $image, $description));
                                        }
                                    @endphp


                                    @foreach ($timelines as $timeline)
                                        @if ($loop->iteration % 2 != 0)
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                                    <h2 class="my-3" style="color: #920B12;">
                                                        <b>{{ $timeline->year }}</b></h2>
                                                    <p>{{ $timeline->description }}</p>
                                                </div>
                                                <div class="col-md-6 order-md-2 mb-3">
                                                    <img src="{{ asset('storage/about-us/' . $timeline->image) }}"
                                                        alt="1998"
                                                        style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                                </div>
                                            </div>
                                        @else
                                            <div class="row align-items-center justify-content-center">
                                                <div class="col-md-6 order-md-2 mb-3">
                                                    <h2 class="my-3" style="color: #920B12;">
                                                        <b>{{ $timeline->year }}</b></h2>
                                                    <p>{{ $timeline->description }}</p>
                                                </div>
                                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                                    <img src="{{ asset('storage/about-us/' . $timeline->image) }}"
                                                        alt="2005"
                                                        style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    {{-- <div class="row align-items-center justify-content-center">
                                        <div class="col-md-6 order-md-1 text-md-end mb-3">
                                            <h2 class="my-3" style="color: #920B12;"><b>1998</b></h2>
                                            <p>Established in 1998, an emerging leader in the aluminum and glass industries.
                                                TQMP PHILIPPINES handles importations and trading of flat glass and other related products such as engineering adhesives, silicone sealants, abrasives, hardware for glass and aluminum installations, and the like.</p>
                                        </div>
                                        <div class="col-md-6 order-md-2 mb-3">
                                            <img src="{{ asset('storage/about-us/alcophil.png') }}" alt="1998" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-2 mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>2005</b></h2>
                                    <p>Armed with strong determination to meet the demand of the customers for high-end architectural and industrial glass requirements, the company formed its first subsidiary company in 2005, the Philippine Glass Processing Specialist, Inc. (PGPSI), and invested in several state-of-the-art processing machines.</p>
                                </div>
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <img src="{{ asset('storage/about-us/glassp.png') }}" alt="2005" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>Third Quarter of 2010</b></h2>
                                    <p>In the third quarter of 2010, Assure Insurance Agency Corporation (AIAC), another subsidiary company of TQMP PHILIPPINES, was established. Assure Insurance Agency Corporation is the insurance arm of the company representing various insurance companies for non-life coverages.</p>
                                </div>
                                <div class="col-md-6 order-md-2 mb-3">
                                    <img src="{{ asset('storage/about-us/aiac.png') }}" alt="2010 Q3" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-2 mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>Fourth Quarter of 2010</b></h2>
                                    <p>In the fourth quarter of 2010, another subsidiary company, TQMC Marketing, was established. TQMC Marketing imports and distributes a wide variety of chemicals and raw ingredients for numerous industrial and food processing applications.</p>
                                </div>
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <img src="{{ asset('storage/about-us/tqmc.png') }}" alt="2010 Q4" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>Fourth Quarter of 2013</b></h2>
                                    <p>In the fourth quarter of 2013, TQMP-Cebu was established. It houses the glass processing facilities that cater to the demands of Cebu and nearby provinces (Visayan Region).</p>
                                </div>
                                <div class="col-md-6 order-md-2 mb-3">
                                    <img src="{{ asset('storage/about-us/wdg.png') }}" alt="2013 Q4" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-2 mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>Second Quarter of 2014</b></h2>
                                    <p>Southern Philippines Glass (SPG) started its operations in the second quarter of 2014 with the same facilities of TQMP-Cebu. It serves the growing demand of the Mindanao Region.</p>
                                </div>
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <img src="https://th.bing.com/th/id/OLC.d45VbMr0TG1XzQ480x360?&rs=1&pid=ImgDetMain" alt="2014 Q2" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>Fourth Quarter of 2014</b></h2>
                                    <p>In the fourth quarter of 2014, the new plant in Lawang Bato started its maiden operation. It houses one of the biggest tempering and modern glass processing facilities in Southeast Asia.</p>
                                </div>
                                <div class="col-md-6 order-md-2 mb-3">
                                    <img src="{{ asset('storage/logos/tqmpnew-edited.jpg') }}" alt="2014 Q4" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-2 mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>First Quarter of 2018</b></h2>
                                    <p>In the first quarter of 2018, TQMP Glass Manufacturing Corp acquired 100% of the AGPH shares and now operates the Philippine Float Glass Plant under the name Pioneer Float Glass Manufacturing Inc. (PFGMI)</p>
                                </div>
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <img src="{{ asset('storage/logos/pfgmi.jpg') }}" alt="2018 Q1" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>Fourth Quarter of 2022</b></h2>
                                    <p>In the fourth quarter of 2022, this the company experiencing a hard time at marketing so we try different side of view for the marketing. "Bulletproofing" which we called MASTER Armoured Vehicle which is your premier source for top-of-the-line and precision-engineered armoured vehicles</p>
                                </div>
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <img src="{{ asset('storage/logos/bulletproof-10.jpg') }}" alt="2022 Q4" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                            <div class="row align-items-center justify-content-center">
                                <div class="col-md-6 order-md-2 mb-3">
                                    <h2 class="my-3" style="color: #920B12;"><b>Fourth Quarter of 2024</b></h2>
                                    <p>In the fourth quarter of 2024, TQMP was seeking for extending their marketing, then it establish another company. HSP Paragon Corporation, which equipped with both powder coating and anodizing lines, is committed to mass-producing and advancing high-end aluminum profiles. Our facility also features a recycling plant for all types of aluminum scraps, ensuring comprehensive solutions for your aluminum section needs.</p>
                                </div>
                                <div class="col-md-6 order-md-1 text-md-end mb-3">
                                    <img src="{{ asset('storage/logos/about-bg-q4.jpg') }}" alt="2024 Q4" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px;">
                                </div>
                            </div>
                        </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
    </section>

    <section id="values-company" class="mt-5 py-5">
        <div class="container text-center">
            <h2 class="fw-bold">Company Values</h2>
            <p class="mt-3">
            <p>Our belief is that our employees are the source of our strength, and that success can only be achieved
                through involvement and full commitment of every TQMP employee.</p>
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm" style="height: 450px;">
                        <img src="{{ asset('storage/about-us/' . $settings['ABOUT_US_MISSION_IMAGE']) }}" alt="Category 1"
                            class="card-img-top rounded">
                        <div class="card-body">
                            <h5 class="fw-bold">MISSION</h5>
                            <p class="text-muted">{{ $settings['ABOUT_US_MISSION_DESC'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm" style="height: 450px;">
                        <img src="{{ asset('storage/about-us/' . $settings['ABOUT_US_VISION_IMAGE']) }}" alt="Category 1"
                            class="card-img-top rounded">
                        <div class="card-body">
                            <h5 class="fw-bold">VISION</h5>
                            <p class="text-muted">{{ $settings['ABOUT_US_VISION_DESC'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm" style="height: 450px;">
                        <img src="{{ asset('storage/about-us/' . $settings['ABOUT_US_VALUES_IMAGE']) }}" alt="Category 1"
                            class="card-img-top rounded">
                        <div class="card-body">
                            <h5 class="fw-bold">OUR VALUES</h5>
                            <p class="text-muted">{{ $settings['ABOUT_US_VALUES_DESC'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    @php
        class VideoTour
        {
            public $url;

            public function __construct($url)
            {
                $this->url = $url;
            }
        }

        $links = [];

        $count = $settings_raw
            ->filter(fn($item) => str_contains($item->key, 'ABOUT_US_VIDEO_TOUR'))
            ->count();

        for ($i = 1; $i <= $count; $i++) {
            $url = $settings['ABOUT_US_VIDEO_TOUR' . $i];
            array_push($links, new VideoTour($url));
        }
    @endphp
    
    <section id="videoTour" class="py-5 mt-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Video Tour</h2>
                <p>
                    We are a leading glass and aluminum fabrication company delivering precision-crafted solutions for
                    residential, commercial, and industrial projects. With years of expertise, we transform raw
                    materials into high-quality finished products built to last.
                </p>
            </div>
            <div class="row g-3">
                @foreach($links as $link)
                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="shadow-sm">
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $link->url; }}" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- <div class="col-12 col-sm-6 col-lg-4">
                    <div class="shadow-sm">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/1f1xlzWFzLE" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-lg-4">
                    <div class="shadow-sm">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/nDshxId1lFk" allowfullscreen></iframe>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    @include ('plus.scripts')
    @include ('plus.accordion')
    @include('plus.chatbot')
    @include ('plus.footer')
</body>

</html>
