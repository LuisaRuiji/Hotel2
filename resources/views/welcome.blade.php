<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <title>Hotel de Luna y Servicio</title>
    <link rel="icon" type="image/png" href="/images/logo-only.png">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-primary py-3">
  <div class="container-fluid">
    
    <!-- Left: Logo + Brand -->
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="logo.svg" alt="Logo" width="24" height="24" class="me-2">
      <span class="fs-5">Hotel de Luna y Servicio</span>
    </a>

    <!-- Toggle button (for mobile) -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Center: Nav Links -->
    <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
  <div class="bg-secondary px-4 py-2 rounded" style="max-width: 600px; width: 100%;">
    <ul class="navbar-nav d-flex flex-row justify-content-between w-100">
      <li class="nav-item">
        <a class="nav-link active border-bottom border-primary" href="#">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="#">Bookings</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="#">Room Availability</a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-light" href="#">Contacts</a>
      </li>
    </ul>
  </div>
</div>

    <!-- Right: Login Button -->
    <div class="d-none d-lg-block">
      <button id="loginButton" class="btn btn-light d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#loginModal">
        <i class="bi bi-box-arrow-in-right me-2"></i> Login
      </button>
    </div>
  </div>
</nav>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('login') }}">
          @csrf
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>

            <!-- content -->
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            @yield('content')
            </div>

<!-- Footer Section -->
<footer class="bg-dark text-light py-4 mt-5">
  <div class="container text-center">
    <p>&copy; 2023 Hotel de Luna y Servicio. All rights reserved.</p>
    <p>Follow us on:
      <a href="#" class="text-light">Facebook</a> |
      <a href="#" class="text-light">Twitter</a> |
      <a href="#" class="text-light">Instagram</a>
    </p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>