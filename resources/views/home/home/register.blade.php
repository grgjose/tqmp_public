<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body>
    @include('plus.navbar')

    <section id="title">
        <div class="container text-center py-5 mt-5 fade-in-up">
            <span class="badge text-white mb-2" style="background-color: #950101; font-size:large;">Register</span>
            <h2 class="fw-bold">Create your own account</h2>
            <p class="mt-3">
                Create your Account to avail more features likes online deliveries and fast transaction. 
            </p>
        </div>
    </section>
    <div class="container py-2 fade-in-up">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="">
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
                        <form action="/register" method="post" enctype='multipart/form-data'>
                            @csrf
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <label for="fname" class="form-label">First Name <span class="text-danger">*</span></label>
                                        <input type="text" id="fname" name="fname" class="form-control" placeholder="Input First Name" required />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <label for="mname" class="form-label">Middle Name</label>
                                        <input type="text" id="mname" name="mname" class="form-control" placeholder="Input Middle Name" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-outline">
                                        <label for="lname" class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <input type="text" id="lname" name="lname" class="form-control" placeholder="Input Last Name" required />
                                    </div>
                                </div>
                            </div>
                            <div class="form-outline mb-4">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Input your Email address" required />
                            </div>
                            <div class="form-outline mb-4">
                                <label for="contact_num" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" id="contact_num" name="contact_num" class="form-control" placeholder="Enter Contact Number" required />
                            </div>
                            <div class="form-outline mb-4">
                                <label for="birthdate" class="form-label">Birthdate <span class="text-danger">*</span></label>
                                <input type="date" id="birthdate" name="birthdate" class="form-control" placeholder="Birthday" required />
                            </div>
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
                            <div class="form-outline mb-4">
                                <label for="upload_file" class="form-label">Please upload your government ID and/or Business Registration if you're a business owner. Be Our Partner to enjoy our Best Price Offers. <span class="text-danger">*</span></label>
                                <input type="file" id="upload_file" name="upload_file" class="form-control" required />
                            </div>
                            <input type="submit" id="registerButton" class="card-button btn btn-danger mt-auto btn-block w-100 mb-3" value="Register">
                            <p class="text-center">
                                Already have an account? <a href="#" class="text-danger text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- @include ('plus.cta') -->
    @include ('plus.accordion')
    @include ('plus.footer')
    @include ('plus.scripts')
</body>
</html>