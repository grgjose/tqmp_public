<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')
    <section id="title">
        <div class="container text-center py-5 fade-in-up">
            <span class="badge text-white mb-2" style="background-color: #950101; font-size:large;">Reset Password</span>
            <p class="mt-3">
                Make sure you remember your new password.
            </p>
        </div>
    </section>
    <div class="container py-2 fade-in-up">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="rounded-4 border border-1 p-5">
                        <h3 class="fw-bold mb-4">Fill out the form</h3>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="/reset-password" method="post" enctype='multipart/form-data'>
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}" />
                            <div class="form-outline mb-4">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your Password" required />
                            </div>
                            <div class="form-outline mb-4">
                                <label for="confirm_password" class="form-label">Confirm your Password <span class="text-danger">*</span></label>
                                <input type="password" id="confirm_password" name="password_confirmation" class="form-control" placeholder="Repeat your Password" required />
                                <div id="passwordError" class="text-danger mt-2" style="display: none;">Passwords do not match.</div>
                            </div>
                            <script>
                                $(document).ready(function () {
                                    $('#password, #confirm_password').on('keyup', function () {
                                        let password = $('#password').val();
                                        let confirmPassword = $('#confirm_password').val();
                                        if (password !== confirmPassword && password !== "") {
                                            $('#passwordError').attr("style", "display: block;");
                                            $('#registerButton').prop('disabled', true);
                                        } else {
                                            $('#passwordError').attr("style", "display: none;");
                                            $('#registerButton').prop('disabled', false);
                                        }
                                    });
                                });
                            </script>
                            <input type="submit" id="registerButton" class="card-button btn btn-primary mt-auto btn-block w-100 mb-3" value="Reset Password">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include ('plus.cta')
    @include ('plus.accordion')
    @include ('plus.footer')
</body>
</html>