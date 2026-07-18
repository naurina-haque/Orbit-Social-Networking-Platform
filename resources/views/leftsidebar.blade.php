<aside class="hp-sidebar">
                <a href="{{ route('profile.show', auth()->id()) }}" class="hp-profile-shortcut">
                    <span class="hp-avatar-ring "><img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                    <div>
                        <div class="hp-name">{{ auth()->user()->name }}</div>
                    </div>
                </a>

                <div class="hp-divider"></div>

                <a href="{{ route('home') }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#EAF1FB">
                        <img src="{{ asset('storage/icons/home.png') }}" class="sidebar-icon" alt="Home">
                    </span>
                    Home
                </a>
                <a href="{{ route('profile.show', auth()->id()) }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#E8F7F4">
                        <img src="{{ asset('storage/icons/user(4).png') }}" class="sidebar-icon" alt="Profile">
                    </span>
                    My Profile
                </a>
                <a href="{{ route('friends') }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#E6F4FD">
                        <img src="{{ asset('storage/icons/friends.png') }}" class="sidebar-icon" alt="Friends">
                    </span>
                    Friends
                </a>
                <a href="{{ route('friend-requests') }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#EAF1FB">
                        <img src="{{ asset('storage/icons/user(1).png') }}" class="sidebar-icon" alt="Friend Requests">
                    </span>
                    Friend Requests
                    
                </a>
                <a href="{{ route('saved-posts') }}" class="hp-nav-item {{ request()->routeIs('saved-posts') ? 'active' : '' }}">
                    <span class="hp-ic" style="background:#FEF6E7">
                        <img src="{{ asset('storage/icons/bookmark.png') }}" class="sidebar-icon" alt="Saved Posts">
                    </span>
                    Saved Posts
                </a>

                <div class="hp-divider"></div>

                <a href="{{ route('profile.edit') }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#F1F5F9">
                        <img src="{{ asset('storage/icons/cogwheel.png') }}" class="sidebar-icon" alt="Settings">
                    </span>
                    Settings
                </a>
            </aside>
