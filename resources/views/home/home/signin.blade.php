<!DOCTYPE html>
<html lang="en">
<head>
    @include ('plus.head')
</head>
<body class="bg-body-secondary">
  <div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow p-4 rounded-4 w-100" style="max-width: 450px;">
      <div class="card-body text-center">
        <h3 class="fw-bold mb-4 text-primary">Welcome Back!</h3>
        <p class="text-muted">Sign in to your account to continue</p>
        <div class="d-flex justify-content-center mb-3">
          <button type="button" class="btn btn-outline-primary btn-floating mx-1">
            <i class="fab fa-facebook-f"></i>
          </button>
          <button type="button" class="btn btn-outline-primary btn-floating mx-1">
            <i class="fab fa-google"></i>
          </button>
          <button type="button" class="btn btn-outline-primary btn-floating mx-1">
            <i class="fab fa-twitter"></i>
          </button>
        </div>
        <p class="text-muted">or sign in with your email</p>
        <form>
          <div class="form-outline mb-3">
            <input type="email" id="email" class="form-control" placeholder="Email address" />
          </div>
          <div class="form-outline mb-3">
            <input type="password" id="password" class="form-control" placeholder="Password" />
          </div>
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe">
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <a href="#" class="text-decoration-none">Forgot password?</a>
          </div>
          <button type="submit" class="btn btn-primary btn-block w-100">Sign In</button>
        </form>
        <div class="mt-3">
          <p class="small">Don't have an account? <a href="#" class="text-decoration-none text-primary">Sign Up</a></p>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
