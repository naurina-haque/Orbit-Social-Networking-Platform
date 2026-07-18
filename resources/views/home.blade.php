<x-app-layout>
    <div class="hp-body">
        <div class="hp-layout">

            <!-- LEFT SIDEBAR -->
            @include('leftsidebar')

            <!-- CENTER FEED -->
            <main>

                <!-- Composer -->
                <section class="hp-card hp-composer" style="margin-top:16px;">
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

                @include('create_post_modal')

                @forelse ($posts as $post)
                    @if (isset($post->shared_by) && $post->user_id !== auth()->id())
                        @include('shared-post-card', ['post' => $post, 'sharedBy' => $post->shared_by])
                    @else
                        @include('post-card', ['post' => $post])
                    @endif
                @empty
                    <div class="hp-card" style="padding:30px; text-align:center; color:#64748B;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:48px;height:48px;margin-bottom:12px;color:#94A3B8;"><path d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/><circle cx="10" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                        <p style="font-size:16px;font-weight:600;color:#1E293B;margin-bottom:6px;">No posts from friends yet</p>
                        <p style="font-size:14px;color:#64748B;">Add some friends or wait for them to post something.</p>
                    </div>
                @endforelse

            </main>

            <!-- RIGHT SIDEBAR -->
            @include('rightsidebar')
        </div>
    </div>
     
</x-app-layout>