<aside class="hp-sidebar">
                <a href="{{ route('profile.edit') }}" class="hp-profile-shortcut">
                    <span class="hp-avatar-ring "><img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                    <div>
                        <div class="hp-name">{{ auth()->user()->name }}</div>
                    </div>
                </a>

                <div class="hp-divider"></div>

                <a href="{{ route('home') }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#EAF1FB">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#3B5BDB"><path d="M3 11.5L12 4l9 7.5"/><path d="M5 10v9a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1v-9"/></svg>
                    </span>
                    Home
                </a>
                <a href="{{ route('profile.show', auth()->id()) }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#E8F7F4">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#14B8A6"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a8 8 0 0116 0v1"/></svg>
                    </span>
                    My Profile
                </a>
                <a href="#" class="hp-nav-item">
                    <span class="hp-ic" style="background:#E6F4FD">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#0EA5E9"><path d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    </span>
                    Friends
                </a>
                <a href="#" class="hp-nav-item">
                    <span class="hp-ic" style="background:#EAF1FB">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#3B5BDB"><path d="M20 8v6M23 11h-6"/><path d="M9 11a4 4 0 100-8 4 4 0 000 8z"/><path d="M1 21v-1a7 7 0 0114 0v1"/></svg>
                    </span>
                    Friend Requests
                    
                </a>
                <a href="{{ route('saved-posts') }}" class="hp-nav-item {{ request()->routeIs('saved-posts') ? 'active' : '' }}">
                    <span class="hp-ic" style="background:#FEF6E7">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#E0A94A"><path d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2z"/></svg>
                    </span>
                    Saved Posts
                </a>

                <div class="hp-divider"></div>

                <a href="{{ route('profile.edit') }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#F1F5F9">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#64748B"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 11-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 11-2.83-2.83l.06-.06A1.65 1.65 0 004.6 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 112.83-2.83l.06.06A1.65 1.65 0 009 4.6a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 112.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                    </span>
                    Settings
                </a>
            </aside>