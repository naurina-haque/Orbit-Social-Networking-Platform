<x-app-layout>
    <div class="hp-body">
        <div class="hp-layout">

            @include('leftsidebar')

            <main>
                <div class="hp-card" style="padding:20px; margin-bottom:16px;">
                    <h2 style="font-size:22px;font-weight:700;">Search Results</h2>
                    <p style="margin-top:8px;color:#64748B;">
                        @if ($search !== '')
                            Showing people matching "{{ $search }}"
                        @else
                            Type a name in the search bar to find people.
                        @endif
                    </p>
                </div>

                <div class="hp-card" style="padding:12px;">
                    @forelse ($users as $user)
                        <a href="{{ route('profile.show', $user->id) }}" class="hp-nav-item" style="margin:0 0 8px; border-radius:14px;">
                            <span class="hp-avatar-ring xs">
                                <img src="{{ $user->profile_photo ?? asset('profileimg.jpg') }}" alt="{{ $user->name }}">
                            </span>
                            <div>
                                <div class="hp-name">{{ $user->name }}</div>
                                <div class="hp-sub">View profile</div>
                            </div>
                        </a>
                    @empty
                        <div style="padding:18px; text-align:center; color:#64748B;">
                            No people matched your search.
                        </div>
                    @endforelse
                </div>
            </main>

            @include('rightsidebar')
        </div>
    </div>
</x-app-layout>