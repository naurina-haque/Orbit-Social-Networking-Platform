<x-app-layout>
    <div class="hp-body">
        <div class="pv-container">

            <!-- Cover + Profile Header -->
            <div class="pv-cover">
                <div class="pv-cover-gradient"></div>
            </div>

            <div class="pv-header hp-card">
                <div class="pv-avatar-wrap">
                    <span class="hp-avatar-ring pv-avatar"><img src="https://i.pravatar.cc/150?img=12" alt=""></span>
                </div>

                <div class="pv-header-info">
                    <h1 class="pv-name">{{ $user->name }}</h1>
                    <p class="pv-handle">{{ Str::slug($user->name) }}</p>
                    @if ($user->bio)
                        <p class="pv-bio">{{ $user->bio }}</p>
                    @endif

                    <div class="pv-stats-row">
                        <div class="pv-stat"><span class="pv-stat-num">{{ $friendsCount }}</span> Friends</div>
                        <div class="pv-stat"><span class="pv-stat-num">{{ $postsCount }}</span> Posts</div>
                    </div>
                </div>

                <div class="pv-header-action">
                    @if ($isOwnProfile)
                        <a href="{{ route('profile.edit') }}" class="pv-edit-btn">Edit Profile</a>
                    @elseif ($isFriend)
                        <button type="button" class="pv-friend-btn" disabled>✓ Friends</button>
                    @elseif ($hasSentRequest)
                        <button type="button" class="pv-friend-btn" disabled>Request Sent</button>
                    @else
                        <button
                            type="button"
                            class="pv-friend-btn add-friend-btn"
                            data-user-id="{{ $user->id }}"
                            data-send-url="{{ route('friend-request.send', $user->id) }}"
                        >
                            Add Friend
                        </button>
                    @endif
                </div>
            </div>

            <!-- Posts -->
            <div class="pv-posts">
                @forelse ($posts as $post)
                    <article class="hp-card hp-post" style="margin-top:16px;">
                        <div class="hp-post-head">
                            <span class="hp-avatar-ring sm"><img src="https://i.pravatar.cc/80?img=12" alt=""></span>
                            <div class="hp-post-meta">
                                <div class="hp-post-name">{{ $post->user->name }}</div>
                                <div class="hp-post-time">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        @if ($post->content)
                            <p class="hp-post-text">{{ $post->content }}</p>
                        @endif

                        @if ($post->image_path)
                            <div class="hp-post-image">
                                <img src="{{ asset('storage/' . $post->image_path) }}" alt="post image">
                            </div>
                        @endif

                        <div class="hp-post-stats">
                            <div class="hp-stats-left">
                                <span class="hp-reaction-dot"><svg viewBox="0 0 24 24"><path d="M12 21s-7-4.5-9.5-9C1 8 3 4 7 4c2 0 4 1.5 5 3 1-1.5 3-3 5-3 4 0 6 4 4.5 8-2.5 4.5-9.5 9-9.5 9z"/></svg></span>
                                {{ $post->likes->count() }}
                            </div>
                            <div>{{ $post->comments->count() }} comments · {{ $post->shares->count() }} shares</div>
                        </div>
                    </article>
                @empty
                    <div class="hp-card" style="padding:40px; text-align:center; margin-top:16px; color:#64748B;">
                        No posts yet.
                    </div>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>