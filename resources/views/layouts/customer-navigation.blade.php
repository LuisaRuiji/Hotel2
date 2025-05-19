<nav class="navbar navbar-expand-lg sticky-top bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <img src="/images/logo-only.png" alt="Hotel Logo" style="height: 40px; width: 40px; margin-right: 8px;">
            Hotel de Luna y Servicio
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.service-request') ? 'active' : '' }}" href="{{ route('customer.service-request') }}">
                        <i class="fas fa-concierge-bell me-2"></i>Service Requests
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('customer.extend-stay') ? 'active' : '' }}" href="{{ route('customer.extend-stay') }}">
                        <i class="fas fa-calendar-plus me-2"></i>Extend Stay
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="fas fa-home me-2"></i>Hotel Website
                    </a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-link text-dark text-decoration-none dropdown-toggle" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user-cog me-2"></i>Profile Settings
                        </a></li>
                        <li><hr class="dropdown-divider"></li>
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
    .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .nav-link.active {
        color: #A7C5BD !important;
        font-weight: 600;
    }
    
    .nav-link:hover {
        color: #A7C5BD !important;
    }

    .dropdown-item:hover {
        background-color: #f5f7f6;
    }

    .dropdown-item.text-danger:hover {
        background-color: #fee2e2;
    }
</style>
@endpush 