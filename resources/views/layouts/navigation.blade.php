<nav class="navbar">
    <div class="nav-container">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="nav-logo">
            <span class="logo-mark">
                <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5">
                    <ellipse cx="12" cy="12" rx="9" ry="4" transform="rotate(30 12 12)"/>
                    <ellipse cx="12" cy="12" rx="9" ry="4" transform="rotate(-30 12 12)"/>
                    <circle cx="12" cy="12" r="2" fill="#fff" stroke="none"/>
                </svg>
            </span>
            <span class="logo-text">Orbit</span>
        </a>

        <!-- Search -->
        <form class="nav-search" action="#" method="GET">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7"/>
                <path d="M21 21l-4.3-4.3" stroke-linecap="round"/>
            </svg>
            <input type="text" name="search" placeholder="Search people on Orbit">
        </form>

        <!-- Center Links -->
        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 11.5L12 4l9 7.5"/>
                    <path d="M5 10v9a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1v-9"/>
                </svg>
            </a>

            <a href="#" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/>
                    <circle cx="10" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 00-3-3.87"/>
                    <path d="M16 3.13a4 4 0 010 7.75"/>
                </svg>
            </a>

             <!-- Friend Requests -->
            <a href="#" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="#3B5BDB"><path d="M20 8v6M23 11h-6"/><path d="M9 11a4 4 0 100-8 4 4 0 000 8z"/><path d="M1 21v-1a7 7 0 0114 0v1"/></svg>
                <span class="badge">5</span>

            </a>

            <!-- Notifications -->
            <a href="#" class="nav-link">
                <svg viewBox="0 0 24 24" fill="none" stroke="#3B5BDB"><path d="M18 8a6 6 0 00-12 0c0 7-3 9-3 9h18s-3-2-3-9"/>
                    <path d="M13.7 21a2 2 0 01-3.4 0"/>
                </svg>
                <span class="badge">5</span>
            </a>
        </div>

        <!-- Right Icons -->
        <div class="nav-right">

           

            <!-- Profile Dropdown -->
            <div class="profile-menu">
                <button class="profile-btn" onclick="document.getElementById('profileDropdown').classList.toggle('show')">
                    <span class="avatar-ring">
                        <img src="https://i.pravatar.cc/80?img=12" alt="profile">
                    </span>
                </button>
                <div class="dropdown" id="profileDropdown">
                    <a href="{{ route('profile.show', auth()->id()) }}" class="dropdown-item">Profile</a>
                    <a href="#" class="dropdown-item">Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item logout">Logout</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</nav>