<!DOCTYPE html>
<html lang="en">

<head>
    @include('plus.head')
</head>

<body>
    @include('plus.navbar')

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="otp-card">
            <div class="otp-title">Enter your phone number</div>
            <div class="otp-subtitle">
                We will send you a one time OTP for verification
            </div>

            <input id="phone-input" type="tel" class="form-control mb-3" placeholder="Enter phone number"
                inputmode="numeric" pattern="[0-9]*"
                oninput="this.value = this.value.replace(/[^0-9]/g, ''); checkPhone();">

            <button id="otp-btn" class="btn btn-otp w-100" disabled>Get OTP</button>
        </div>
    </div>

    <script>
        function checkPhone() {
            const phone = document.getElementById('phone-input').value;
            document.getElementById('otp-btn').disabled = phone.length === 0;
        }
    </script>

    @include ('plus.chatbot')
    @include ('plus.footer')
</body>

</html>
