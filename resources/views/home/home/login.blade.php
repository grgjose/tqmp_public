<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="icon" href="{{ asset('storage/logos/TQMPLogo.png') }}" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body class="bg-body-secondary d-flex align-items-center" style="height: 100vh;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm rounded-4">
          <div class="card-body p-5">
            <h2 class="text-center fw-bold mb-4 text-danger">Login</h2>
            <p class="text-center text-muted mb-4">Access your account</p>
            <form action="/login" method="post">
              @csrf
              <div class="form-outline mb-4">
                <input type="email" id="loginEmail" name="email" class="form-control" placeholder="Email address" required />
              </div>
              <div class="form-outline mb-4">
                <input type="password" id="loginPassword" name="password" class="form-control" placeholder="Password" required />
              </div>
              <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="rememberMe" />
                  <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
                <a href="#" class="text-decoration-none text-danger">Forgot password?</a>
              </div>
              <input type="submit" class="btn btn-primary btn-block w-100 mb-3" value="Login">
              <p class="text-center small">
                Don't have an account? <a href="/register" class="text-danger text-decoration-none">Register</a>
              </p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>