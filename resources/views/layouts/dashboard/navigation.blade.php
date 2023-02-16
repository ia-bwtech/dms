<ul class="nav flex-column pt-3 pt-md-0">
    <li class="nav-item">
        <a href="/" class="nav-link d-flex align-items-center">
            <span class="sidebar-icon me-3">
                <img src="{{ asset('images/brand/light.svg') }}" height="20" width="20" alt="Volt Logo">
            </span>
            <span class="mt-1 ms-1 sidebar-text">
                Blind Side Bets
            </span>
        </a>
    </li>

    {{-- Admin Links --}}
    @role('admin')
        <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-house-user"></i>
                </span>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.handicappers') ? 'active' : '' }}">
            <a href="{{ route('admin.handicappers') }}" class="nav-link">
                <span class="sidebar-icon">
                    <i class="fas fa-user-alt fa-fw"></i>
                </span>
                <span class="sidebar-text">Handicappers</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('faqs') ? 'active' : '' }}">
            <a href="{{ route('faqs') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fa fa-sticky-note"></i>
                </span>
                <span class="sidebar-text">FAQs</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('admin.bets') ? 'active' : '' }}">
            <a href="{{ route('admin.bets') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-archive"></i>
                </span>
                <span class="sidebar-text">All Bets</span>
            </a>
        </li>
    @endrole

    {{-- User links --}}
    @role('user')
        <li class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-house-user"></i>
                </span>
                <span class="sidebar-text">Dashboard</span>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('user.packages') ? 'active' : '' }}">
            <a href="{{ route('user.packages') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-archive"></i>
                </span>
                <span class="sidebar-text">Packages</span>
            </a>
        </li>
        @if (auth()->user()->is_handicapper == 1)
            <li class="nav-item {{ request()->routeIs('user.payments') ? 'active' : '' }}">
                <a href="{{ route('user.payments') }}" class="nav-link">
                    <span class="sidebar-icon me-3">
                        <i class="fas fa-dollar-sign"></i>
                    </span>
                    <span class="sidebar-text">Payments Setup</span>
                </a>
            </li>
        @endif
        <li class="nav-item {{ request()->routeIs('user.bets') ? 'active' : '' }}">
            <a href="{{ route('user.bets') }}" class="nav-link">
                <span class="sidebar-icon me-3">
                    <i class="fas fa-archive"></i>
                </span>
                <span class="sidebar-text">My Bets</span>
            </a>
        </li>
        @if (auth()->user()->is_handicapper == 1)
            <li class="nav-item {{ request()->routeIs('user.subscribers') ? 'active' : '' }}">
                <a href="{{ route('user.subscribers') }}" class="nav-link">
                    <span class="sidebar-icon me-3">
                        <i class="fas fa-user"></i>
                    </span>
                    <span class="sidebar-text">My Subscribers</span>
                </a>
            </li>
        @endif
    @endrole

    <li class="nav-item {{ request()->routeIs('profile.show') ? 'active' : '' }}">
        <a href="{{ route('profile.show') }}" class="nav-link">
            <span class="sidebar-icon me-3">
                <i class="fas fa-user"></i>
            </span>
            <span class="sidebar-text">My Profile</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <span class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            data-bs-target="#submenu-app">
            <span>
                <span class="sidebar-icon me-3">
                    <i class="fas fa-circle fa-fw"></i>
                </span>
                <span class="sidebar-text">Two-level menu</span>
            </span>
            <span class="link-arrow">
                <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd">
                    </path>
                </svg>
            </span>
        </span>
        <div class="multi-level collapse" role="list" id="submenu-app" aria-expanded="false">
            <ul class="flex-column nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="sidebar-icon">
                            <i class="fas fa-circle"></i>
                        </span>
                        <span class="sidebar-text">Child menu</span>
                    </a>
                </li>
            </ul>
        </div>
    </li> --}}
</ul>
