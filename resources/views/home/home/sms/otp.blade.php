<!DOCTYPE html>
<html lang="en">

<head>
    @include('plus.head')
</head>

<body>
    @include('plus.navbar')
    <style>

    </style>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="otp-card">

            <div class="otp-title">Enter verification code</div>

            <div class="otp-subtitle">
                Please enter the OTP (One-Time Password)<br>
                sent to your registered email/phone number<br>
                to complete your verification.
            </div>

            <!-- OTP Inputs -->
            <div class="d-flex justify-content-center otp-inputs mb-3">
                <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                    onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                    onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                    onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                    onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                    onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
                <input type="tel" maxlength="1" inputmode="numeric" pattern="[0-9]*"
                    oninput="this.value=this.value.replace(/[^0-9]/g,''); if(this.value) this.nextElementSibling?.focus();"
                    onkeyup="if(event.key==='Backspace') { this.previousElementSibling?.focus(); } checkOtp();">
            </div>

            <!-- Timer -->
            <div class="timer mb-3">
                Remaining time: <span id="timer">00:49</span>
            </div>

            <script>
                let seconds = 49;

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

    @include ('plus.chatbot')
    @include ('plus.footer')


</body>

</html>
