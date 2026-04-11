<!DOCTYPE html>
<html lang="en">

<head>
    @include('plus.head')
</head>

<body>
    @include('plus.navbar')

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="success-card">

            <!-- Circle with Check -->
            <div class="cross-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>

            <!-- Text -->
            <div class="title">Unsuccessful!</div>
            <div class="subtitle">
                OTP is unsuccessful, please try again
            </div>

            <!-- Button -->
            <button class="btn btn-login w-100">Go Back</button>

        </div>
    </div>

    @include ('plus.chatbot')
    @include ('plus.footer')
</body>

</html>
