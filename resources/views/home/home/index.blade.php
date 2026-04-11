<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Total Quality Management Products Philippines">
    <meta name="author" content="TQMP">
    <link rel="icon" href="{{ asset('storage/logos/TQMPLogo.png') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Welcome to TQMP Page!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/pageWelcomeStyle.css') }}">
</head>

<body>

    <div class="welcome-container fade-in">
        <div style="background-image: url('{{ asset('storage/logos/'.$settings['WELCOME_BACKGROUND']) }}');
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;">
    </div>
        <div class="overlay"></div>
        <div class="content">
            <a class="navbar-brand d-inline-flex text-decoration-none">
                <img src="{{ asset('storage/logos/'.$settings['WELCOME_LOGO']) }}"
                    alt="Header Image"
                    class="img-fluid"
                    style="max-height: 200px;">
            </a>
            {!! $settings['WELCOME_TITLE'] !!}
            {!! $settings['WELCOME_DESCRIPTION'] !!}
            <a href="/home" class="btn-get-started">
                Get Started
                <i class="bi bi-arrow-right arrow-icon"></i>
            </a>
        </div>
        {!! $settings['WELCOME_BOTTOM_RIGHT_LOGO'] !!}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>