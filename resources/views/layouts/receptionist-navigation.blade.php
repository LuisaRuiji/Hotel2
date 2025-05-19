<nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('receptionist.dashboard') }}">
            <img src="/images/logo-only.png" alt="Hotel Logo" style="height: 40px; width: 40px; margin-right: 8px;">
            Hotel de Luna y Servicio
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('receptionist.dashboard') ? 'active' : '' }}"
                        href="{{ route('receptionist.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('receptionist.rooms') ? 'active' : '' }}"
                        href="{{ route('receptionist.rooms') }}">
                        <i class="fas fa-bed me-2"></i>Rooms
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('receptionist.checkin') ? 'active' : '' }}"
                        href="{{ route('receptionist.checkin') }}">
                        <i class="fas fa-sign-in-alt me-2"></i>Check-in
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('receptionist.checkout') ? 'active' : '' }}"
                        href="{{ route('receptionist.checkout') }}">
                        <i class="fas fa-sign-out-alt me-2"></i>Check-out
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" type="button"
                        id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <i class="fas fa-user-cog me-2"></i>Profile Settings
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

@push('styles')
    <style>
        a.nav-link {
            color: white;
        }

        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .nav-link.active {
            color: var(--accent-color) !important;
            font-weight: 600;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .dropdown-item:hover {
            background-color: var(--light-bg);
        }

        .dropdown-item.text-danger:hover {
            background-color: #fee2e2;
        }
    </style>
@endpush