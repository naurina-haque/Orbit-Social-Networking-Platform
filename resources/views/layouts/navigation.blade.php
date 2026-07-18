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
        <form class="nav-search" action="{{ route('people.search') }}" method="GET">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="7"/>
                <path d="M21 21l-4.3-4.3" stroke-linecap="round"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search people on Orbit">
        </form>
       

        <!-- Center Links -->
        <div class="nav-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                <img src="{{ request()->routeIs('home') ? asset('storage/icons/home(1).png') : asset('storage/icons/home.png') }}" class="nav-icon" alt="Home">
            </a>

            <a href="{{ route('friends') }}" class="nav-link {{ request()->routeIs('friends') ? 'active' : '' }}">
                <img src="{{ request()->routeIs('friends') ? asset('storage/icons/friends(1).png') : asset('storage/icons/friends.png') }}" class="nav-icon" alt="Friends">
            </a>

             <!-- Friend Requests -->
             <a href="{{ route('friend-requests') }}" class="nav-link {{ request()->routeIs('friend-requests') ? 'active' : '' }}">
                 <img src="{{ request()->routeIs('friend-requests') ? asset('storage/icons/user(2).png') : asset('storage/icons/user(1).png') }}" class="nav-icon" alt="Friend Requests">
                 @if ($friendRequestCount > 0)
                     <span class="badge">{{ $friendRequestCount }}</span>
                 @endif

             </a>

             <!-- Notifications -->
             <a href="{{ route('notifications') }}" class="nav-link {{ request()->routeIs('notifications') ? 'active' : '' }}">
                 <img src="{{ request()->routeIs('notifications') ? asset('storage/icons/notification(1).png') : asset('storage/icons/notification.png') }}" class="nav-icon" alt="Notifications">
                 @if ($notificationCount > 0)
                     <span class="badge">{{ $notificationCount }}</span>
                 @endif
                 
             </a>
        </div>

        <!-- Right Icons -->
        <div class="nav-right">

            

            <!-- Profile Dropdown -->
            <div class="profile-menu">
                <button class="profile-btn" onclick="document.getElementById('profileDropdown').classList.toggle('show')">
                    <span class="avatar-ring">
                        <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profileimg.jpg') }}" alt="profile">
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