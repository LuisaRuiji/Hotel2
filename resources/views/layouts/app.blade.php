<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hotel de Luna y Servicio</title>
    <link rel="icon" type="image/png" href="/images/logo-only.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')

    <!-- Scripts -->
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</head>
<body>
    <div class="min-vh-100 bg-light">
        @auth
            @if(auth()->user()->role === 'receptionist')
                @include('layouts.receptionist-navigation')
            @elseif(auth()->user()->role === 'admin')
                @include('layouts.admin-navigation')
            @else
                @include('layouts.customer-navigation')
            @endif
        @else
            <!-- Guest Navigation Bar -->
            <nav class="navbar navbar-expand-lg navbar-light shadow-sm" style="background: linear-gradient(90deg, #1E3A5F 0%, #3B82F6 50%, #14B8A6 100%); min-height: 80px; padding-top: 1rem; padding-bottom: 1rem;">
                <div class="container">
                    <div class="navbar-brand-wrapper position-relative d-flex align-items-center" style="height: 64px;">
                        <div class="logo-bg position-absolute top-50 start-0 translate-middle-y" style="width: 100px; height: 80px; z-index: 1;"></div>
                        <div class="d-flex align-items-center justify-content-center position-relative" style="z-index: 2; height: 64px;">
                            <img src="/images/logo-only.png" alt="Hotel Logo" style="height: 80px; width: 150px;">
                        </div>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#guestNavbarNav" 
                            aria-controls="guestNavbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="guestNavbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom" href="{{ url('/') }}">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom" href="#rooms">Rooms</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom" href="#services">Services</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto d-flex align-items-center">
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-custom" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary-custom" href="{{ route('register') }}">Register</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        @endauth

        <!-- Main Content -->
        <main id="content" class="py-4">
            @yield('content')
        </main>
    </div>

    @auth
    @else
        @include('components.login-modal')
    @endauth

    @stack('scripts')

    <script>
        // Setup HTMX CSRF token
        document.body.addEventListener('htmx:configRequest', function(event) {
            event.detail.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
        });

        // Show loading indicator
        htmx.on('htmx:beforeRequest', function(event) {
            const target = event.detail.target;
            if (target.id === 'content') {
                target.classList.add('htmx-loading');
            }
        });

        // Hide loading indicator
        htmx.on('htmx:afterRequest', function(event) {
            const target = event.detail.target;
            if (target.id === 'content') {
                target.classList.remove('htmx-loading');
            }
        });

        // Show login modal if redirected with show_login_modal flag
        @if(session('show_login_modal'))
        document.addEventListener('DOMContentLoaded', function() {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        });
        @endif

        // Handle Book Now buttons for guest users
        document.addEventListener('DOMContentLoaded', function() {
            // Find all Book Now buttons at page load
            const bookButtons = document.querySelectorAll('.book-now-btn');
            
            // Add click event listeners to each button
            bookButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    @auth
                        // If user is logged in, go to the book URL
                        const bookUrl = this.getAttribute('data-book-url');
                        if (bookUrl) {
                            window.location.href = bookUrl;
                        }
                    @else
                        // If user is not logged in, prevent default and show login modal
                        e.preventDefault();
                        
                        // Store the room ID for after login
                        const roomId = this.getAttribute('data-room-id');
                        if (roomId) {
                            sessionStorage.setItem('intended_room_booking', roomId);
                        }
                        
                        // Show login modal
                        const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                        loginModal.show();
                    @endauth
                });
            });
        });
    </script>

    <style>
        :root {
            --primary: #D946EF;
            --secondary: #3B82F6;
            --dark: #1E3A5F;
            --accent: #5EEAD4;
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            background: linear-gradient(120deg, #F8FAFC 70%, #E0E7EF 100%);
        }

        /* Navbar Styles */
        .navbar {
            background: linear-gradient(90deg, #1E3A5F 0%, #3B82F6 50%, #14B8A6 100%) !important;
            min-height: 80px;
            box-shadow: 0 2px 8px rgba(59, 130, 246, 0.08);
        }

        .navbar-brand-wrapper {
            min-width: 90px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            position: relative;
        }

        .navbar-brand img {
            height: 64px !important;
            width: auto;
            background: none;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
        }

        .nav-link-custom {
            color: #fff !important;
            font-size: 1.15rem;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 0.75rem 1.25rem;
            border-radius: 8px;
            transition: var(--transition);
            position: relative;
            background: none;
        }

        .nav-link-custom:hover, .nav-link-custom.active {
            color: #D946EF !important;
            background: rgba(217, 70, 239, 0.08);
        }

        .btn-primary-custom {
            background-color: #5EEAD4;
            border-color: #5EEAD4;
            color: #1E3A5F;
            font-weight: 600;
            border-radius: 8px;
            transition: var(--transition);
            padding: 0.5rem 1.5rem;
        }

        .btn-primary-custom:hover {
            background-color: #D946EF;
            border-color: #D946EF;
            color: #fff;
            box-shadow: 0 4px 12px rgba(217, 70, 239, 0.15);
        }

        .btn-outline-custom {
            color: #1E3A5F;
            border: 2px solid #5EEAD4;
            background: transparent;
            border-radius: 8px;
            transition: var(--transition);
            padding: 0.5rem 1.5rem;
        }

        .btn-outline-custom:hover {
            background-color: #5EEAD4;
            color: #1E3A5F;
            box-shadow: 0 4px 12px rgba(94, 234, 212, 0.15);
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        .slide-up {
            animation: slideUp 0.5s ease-out;
        }

        /* Loading States */
        .htmx-loading {
            opacity: 0.5;
            transition: opacity 300ms ease-in;
        }
        
        .htmx-settling {
            opacity: 0;
        }
        
        .htmx-request {
            animation: fade-in 300ms ease-in;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card Hover Effects */
        .card {
            transition: var(--transition);
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--secondary);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }

        /* Premium Services Section */
        #services .section-header-accent {
            width: 60px;
            height: 4px;
            margin: 0.5rem auto 2rem auto;
            background: linear-gradient(90deg, #D946EF 0%, #5EEAD4 100%);
            border-radius: 2px;
        }
        #services .card {
            border-radius: 18px;
            border-top: 4px solid #D946EF;
            transition: box-shadow 0.3s, transform 0.3s, border-color 0.3s;
            box-shadow: 0 2px 12px rgba(30,58,95,0.07);
        }
        #services .card:hover {
            box-shadow: 0 8px 32px rgba(30,58,95,0.18);
            border-top: 4px solid #5EEAD4;
            transform: translateY(-8px) scale(1.03);
        }
        #services .card-title {
            font-weight: 700;
            color: #1E3A5F;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        #services .badge {
            border-radius: 999px;
            background: linear-gradient(90deg, #D946EF 0%, #5EEAD4 100%);
            color: #fff !important;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.4em 1em;
        }
        #services .btn-book-service {
            background: linear-gradient(90deg, #3B82F6 0%, #D946EF 100%);
            color: #fff;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            transition: background 0.3s, transform 0.2s;
        }
        #services .btn-book-service:hover {
            background: linear-gradient(90deg, #D946EF 0%, #5EEAD4 100%);
            color: #fff;
            transform: translateY(-2px) scale(1.03);
        }
    </style>
</body>
</html>