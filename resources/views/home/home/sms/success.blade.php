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
            <div class="check-circle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Text -->
            <div class="title">Successful!</div>
            <div class="subtitle">
                OTP is successful, you can now login using your account
            </div>

            <!-- Button -->
            <button class="btn btn-login w-100" data-bs-toggle="modal" data-bs-target="#loginModal">Log in</button>

        </div>
    </div>

    @include ('plus.chatbot')
    @include ('plus.footer')
</body>

</html>
