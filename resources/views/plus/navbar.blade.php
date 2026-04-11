<style>
    .dropdown-menu {
        z-index: 9999 !important;
        /* Forces dropdowns to the very front */
    }
</style>

<div class="fixed-top">

    <div style="background-color:#841617;">
        <div class="container">
            {!! $settings_nav['NAVBAR_ANNOUNCEMENT_BAR'] !!}
            {{-- <div class="row py-2 py-md-3 text-white">
                <div class="col-md-7 d-flex align-items-center justify-content-center justify-content-md-start fw-semibold text-center text-md-start mb-2 mb-md-0" style="font-size: 0.85rem; line-height: 1.2;">
                    <span class="d-md-none">CREATE AN ACCOUNT & BECOME A PARTNER!</span>
                    <span class="d-none d-md-inline h5 mb-0 fw-bold">CREATE AN ACCOUNT AND BECOME A PARTNER TO ACCESS BEST PRICES!</span>
                </div>

                <div class="col-md-5 d-flex align-items-center justify-content-center justify-content-md-end flex-wrap gap-2 gap-md-4" style="font-size: 0.8rem;">
                    <a href="tel:+63277178767" class="text-white text-decoration-none">
                        <i class="fa-solid fa-phone me-1"></i> +632-7-7178767
                    </a>
                    <a href="mailto:sales@tqmpbiz.com" class="text-white text-decoration-none">
                        <i class="fa-solid fa-envelope me-1"></i> sales@tqmpbiz.com
                    </a>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="bg-white border-bottom">
        <div class="container py-2">
            <div class="row align-items-center">
                <div class="col-md-7 d-flex justify-content-center justify-content-md-start mb-2 mb-md-0">
                    <a href="/home"
                        class="navbar-brand d-flex align-items-center text-decoration-none text-center text-md-start">
                        <img src="{{ asset('storage/logos/'.$settings_nav['NAVBAR_LOGO']) }}" alt="Logo" class="img-fluid"
                            style="height:40px; width:auto;">
                        <span class="ms-2 fw-bold text-danger"
                            style="font-size: clamp(0.9rem, 4vw, 1.4rem); line-height: 1.1;">
                            TQMP GLASS AND ALUMINUM SUPPLIER
                        </span>
                    </a>
                </div>

                <div class="col-md-5 d-flex justify-content-center justify-content-md-end align-items-center">
                    @if ($my_user == null)
                        <a href="/register" class="text-danger fw-semibold me-3 text-decoration-none text-nowrap">
                            Register
                        </a>
                        <button class="btn btn-danger px-4 py-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Login
                        </button>
                    @else
                        <!-- <a href="/profile" class="btn btn-danger px-4 py-2">
                        My Account
                    </a> -->
                        <div class="dropdown me-2" id="notifications">
                            <a href="#"
                                class="nav-link position-relative d-flex align-items-center text-decoration-none dropdown-toggle no-caret"
                                id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-bell fs-4 text-dark"></i>

                                @if ($count_notifications > 0)
                                    <span
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill text-bg-danger"
                                        style="font-size: 0.65rem; transform: translate(-35%, -35%);">
                                        {{ $count_notifications }}
                                    </span>
                                @endif
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-3"
                                aria-labelledby="notificationDropdown" id="notificationsList">
                                <li class="fw-bold mb-2 text-danger mt-2">Notifications</li>

                                @foreach ($notifications as $notif)
                                    <li class="dropdown-item py-2">
                                        <a class="fw-medium text-dark wrap text-decoration-none d-block"
                                            style="width: 300px;" href="{{ $notif->link }}">
                                            {{ $notif->message }}
                                        </a>
                                        <small class="text-muted small d-block">{{ $notif->created_at }}</small>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                @endforeach
                                <li>
                                    <a class="d-block text-center dropdown-item py-2 text-danger text-decoration-none"
                                        href="/notification_user">
                                        View All Notifications
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="dropdown" id="profile">
                            <a href="#"
                                class="d-flex align-items-center text-decoration-none dropdown-toggle me-2"
                                id="profileDropdown" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-circle-user fs-4 me-2 text-dark"></i>
                                <div class="d-none d-md-block" style="line-height:1.1;">
                                    <div class="fw-semibold text-danger" style="font-size:0.95rem;">
                                        {{ $my_user->fname }} {{ $my_user->lname }}
                                    </div>
                                    @if ($my_user->usertype == 1)
                                        <small class="text-muted" style="font-size:0.80rem;">Administrator</small>
                                    @elseif($my_user->usertype == 2)
                                        <small class="text-muted" style="font-size:0.80rem;">Sales
                                            Representative</small>
                                    @elseif($my_user->usertype == 3)
                                        <small class="text-muted" style="font-size:0.80rem;">Customer</small>
                                    @endif
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-4 p-3"
                                aria-labelledby="profileDropdown" style="min-width: 260px;">
                                @if ($my_user->usertype == 3)
                                    <li><a class="dropdown-item" href="/profile"><i class="fa-regular fa-user me-2"></i>
                                            Account</a></li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="/cart">
                                            <span class="position-relative">
                                                <i class="fa-regular fa-heart me-2"></i>
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count"
                                                    style="font-size: 0.5rem; min-width: 14px;"></span>
                                            </span>
                                            Cart
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="/order-status">
                                            <span class="position-relative">
                                                <i class="fa-solid fa-chart-bar me-2"></i>
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger order-count"
                                                    style="font-size: 0.5rem; min-width: 14px;"></span>
                                            </span>
                                            Order Status
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="/quotes-status">
                                            <span class="position-relative">
                                                <i class="fa-solid fa-quote-right me-2"></i>
                                                <span
                                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger quotation-count"
                                                    style="font-size: 0.5rem; min-width: 14px;"></span>
                                            </span>
                                            Quotation Status
                                        </a>
                                    </li>
                                @endif
                                @if ($my_user->usertype == 1 || $my_user->usertype == 2)
                                    <li><a class="dropdown-item" href="/dashboard"><i
                                                class="fa-solid fa-table-columns me-2"></i> Dashboard</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="/logout" method="POST">@csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-sm sticky-top py-2" aria-label="Navbar example">
        <div class="container">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav mx-auto mb-2 mb-md-0">

                    <li class="nav-item fw-bold"><a class="nav-link px-3 text-danger" href="/home">Home</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3 fw-bold text-danger" href="#"
                            data-bs-toggle="dropdown">Bullet Proofing</a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-4 p-3">
                            <li><a class="dropdown-item" href="/bulletproofing">Bullet Proof Armouring</a></li>
                            <li><a class="dropdown-item" href="/bulletproofing#benefits-bulletproofing">Benefits</a>
                            </li>
                            <li><a class="dropdown-item" href="/bulletproofing#videos-bulletproofing">Videos</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3 fw-bold text-danger" href="#"
                            data-bs-toggle="dropdown">Glass MFG</a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-4 p-3">
                            <li><a class="dropdown-item" href="/glassmanufacturing">Glass Manufacturing</a></li>
                            <li><a class="dropdown-item"
                                    href="/glassmanufacturing#products-glass-manufacturing">Products</a></li>
                            <li><a class="dropdown-item" href="/glassmanufacturing#awards">Awards</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3 fw-bold text-danger" href="#"
                            data-bs-toggle="dropdown">Aluminum MFG</a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-4 p-3">
                            <li><a class="dropdown-item" href="/aluminummanufacturing">Aluminum MFG</a></li>
                            <li><a class="dropdown-item"
                                    href="/aluminummanufacturing#about-aluminum-profiles">About</a></li>
                            <li><a class="dropdown-item"
                                    href="/aluminummanufacturing#services-aluminum-profiles">Aluminum Profiles</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3 fw-bold text-danger" href="#"
                            data-bs-toggle="dropdown">Glass Processing</a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-4 p-3">
                            <li><a class="dropdown-item" href="/glassprocessing">Glass Processing</a></li>
                            <li><a class="dropdown-item" href="/glassprocessing#about-glass-processing">About</a></li>
                            <li><a class="dropdown-item"
                                    href="/glassprocessing#services-glass-processing">Services</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3 fw-bold text-danger" href="#"
                            data-bs-toggle="dropdown">Other Products</a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-4 p-3">
                            <li><a class="dropdown-item" href="/gentrade">Architectural Hardwares</a></li>
                        </ul>
                    </li>

                    <li class="nav-item fw-bold"><a class="nav-link px-3 text-danger" href="/shop">Shop</a></li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle px-3 fw-bold text-danger text-danger" href="#"
                            data-bs-toggle="dropdown">About</a>
                        <ul class="dropdown-menu border-0 shadow-sm rounded-4 p-3">
                            <li><a class="dropdown-item" href="/about">Our History</a></li>
                            <li><a class="dropdown-item" href="/about#values-company">Vision and Mission</a></li>
                            <li><a class="dropdown-item" href="/about#videoTour">Video Tour</a></li>
                            <!-- <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#tqmpIntroModal">
                                    Introduction
                                </a>
                            </li> -->
                        </ul>
                    </li>

                    <li class="nav-item fw-bold"><a class="nav-link px-3 text-danger" href="/contact">Contact</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" id="loginModalBody">
            <div class="modal-body text-center p-4">
                <h2 class="text-center fw-bold text-danger pt-3">Login</h2>
                <p class="text-center text-muted mb-4">Access your account</p>
                <form id="loginForm" action="/login" method="post">@csrf
                    <input id="loginEmail" type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                    <input id="loginPassword" type="password" name="password" class="form-control mb-3" placeholder="Password"
                        required>
                    <input id="loginSubmitBtn" type="submit" class="btn btn-danger w-100" value="Login">
                </form>
            </div>
        </div>

        <div class="modal-content d-none" id="otpModal">
            <div class="modal-body text-center p-4">
                <div class="otp-title">Enter verification code</div>

                <div class="otp-subtitle">
                    Please enter the OTP (One-Time Password)<br>
                    sent to your registered email/phone number<br>
                    to complete your verification.
                </div>

                <div id="otp-error" class="alert alert-danger p-2 mb-2" style="display:none;"></div>

                <!-- OTP Inputs -->
                <div class="d-flex justify-content-center otp-inputs mb-3">
                    <input id="otp_digit1" type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                        oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                        onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                    <input id="otp_digit2" type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                        oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                        onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                    <input id="otp_digit3" type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                        oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                        onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                    <input id="otp_digit4" type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                        oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                        onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                    <input id="otp_digit5" type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                        oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                        onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                    <input id="otp_digit6" type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                        oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                        onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">

                </div>

                <!-- Timer -->
                <div class="timer mb-3">
                    Remaining time: <span id="timer">00:49</span>
                </div>

                <script>
                    let seconds = 300; // 5 minutes in seconds

                    const interval = setInterval(() => {
                        seconds--;

                        const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
                        const secs = String(seconds % 60).padStart(2, '0');

                        document.getElementById('timer').textContent = `${mins}:${secs}`;

                        if (seconds <= 0) {
                            clearInterval(interval);
                            document.getElementById('timer').textContent = '00:00';
                        }
                    }, 1000);
                </script>
                <script>
                    function checkOtp() {
                        const inputs = document.querySelectorAll('.otp-inputs input');
                        const allFilled = [...inputs].every(input => input.value.length === 1);
                        document.getElementById('verify-btn').disabled = !allFilled;
                    }
                </script>

                <!-- Button -->
                <button id="verify-btn" class="btn btn-verify w-100 mb-3" disabled>Verify Code</button>

                <!-- Resend -->
                <div>
                    <small>Didn’t get an OTP?</small><br>
                    <span class="resend">Resend Code</span>
                </div>
            </div>
        </div>
    </div>
</div>

