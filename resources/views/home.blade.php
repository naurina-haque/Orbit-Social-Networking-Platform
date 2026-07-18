<x-app-layout>
    <div class="hp-body">
        <div class="hp-layout">

            <!-- LEFT SIDEBAR -->
            @include('leftsidebar')

            <!-- CENTER FEED -->
            <main>

                <!-- Composer -->
                <section class="hp-card hp-composer">
                    <div class="hp-composer-top">
                        <span class="hp-avatar-ring"><img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                        <a href="#createPostModal" class="hp-composer-input">What's on your mind, {{ explode(' ', auth()->user()->name)[0] }}?</a>
                    </div>
                    <div class="hp-composer-divider"></div>
                    <div class="hp-composer-actions">
                        <button class="hp-composer-btn hp-photo">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M21 16l-5-5-4 4-3-3-4 4"/></svg>
                            Photo
                        </button>
                        <button class="hp-composer-btn hp-feeling">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>
                            Feeling
                        </button>
                    </div>
                </section>

                @forelse ($posts as $post)
                    @include('post-card', ['post' => $post])
                @empty
                    <div class="hp-card" style="padding:20px; text-align:center; color:#64748B;">
                        No posts to display.
                    </div>
                @endforelse

            </main>

            <!-- RIGHT SIDEBAR -->
            @include('rightsidebar')
        </div>
    </div>
        @include('create_post_modal')
</x-app-layout>