<aside id="sidebar">
    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="toggle-btn">
        <i class="fa-solid fa-bars-staggered"></i>
    </label>

    <ul class="sidebar-nav">                                
        <li class="sidebar-item">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                <i class="fa-regular fa-user"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.rooms') }}" class="sidebar-link">
            <i class="fa-solid fa-hotel"></i>
                <span>Rooms</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.receptionist') }}" class="sidebar-link">
            <i class="fa-solid fa-bell-concierge"></i>
                <span>Receptionist</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.services') }}" class="sidebar-link">
                <i class="fa-regular fa-user"></i>
                <span>Services</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="sidebar-link"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</aside>
