    <section id="company-logos" class="container py-5 fade-in text-center">
        <div class="w-100">
            <div class="py-5">
                <div class="logo-container">
                    <div class="logo-track">
                        @for($i = 1; $i <= 19; $i++)
                            <img src="{{ asset('storage/home/' . $settings['HOME_BRAND'.(($i - 1) % 7 + 1)]) }}" alt="{{ $settings['HOME_BRAND'.(($i - 1) % 7 + 1)] }}" class="img-fluid mx-2 my-1">
                            @endfor

                            {{-- <img src="{{ asset('storage/logos/assa-abloy-logo.png') }}" alt="Assa Abloy" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/master_armoured_vehicle-logo.png') }}" alt="Master Armoured" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/pgpsi-logo.png') }}" alt="PGPSI" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/pioneer_logo.png') }}" alt="Pioneer" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/thore-logo.png') }}" alt="Thore" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/wacker-logo.png') }}" alt="Wacker" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/yale-logo.png') }}" alt="Yale" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/assa-abloy-logo.png') }}" alt="Assa Abloy" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/master_armoured_vehicle-logo.png') }}" alt="Master Armoured" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/pgpsi-logo.png') }}" alt="PGPSI" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/pioneer_logo.png') }}" alt="Pioneer" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/thore-logo.png') }}" alt="Thore" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/wacker-logo.png') }}" alt="Wacker" class="img-fluid mx-2 my-1">
                            <img src="{{ asset('storage/logos/yale-logo.png') }}" alt="Yale" class="img-fluid mx-2 my-1"> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>