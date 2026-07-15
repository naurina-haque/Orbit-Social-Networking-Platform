<x-app-layout>
    <div class="hp-body">
        <div class="pv-container">

            <!-- Cover + Profile Header -->
            <div class="pv-cover">
                <div class="pv-cover-gradient"></div>
            </div>

            <div class="pv-header hp-card">
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

            <!-- Tabs -->
            <div class="pv-tabs">
                <button type="button" class="pv-tab active" data-tab="posts">Posts</button>
                <button type="button" class="pv-tab" data-tab="friends">Friends ({{ $friendsCount }})</button>
            </div>

            <!-- POSTS TAB -->
            <div class="pv-tab-content" id="pv-tab-posts">

                @if ($isOwnProfile)
                    <section class="hp-card hp-composer" style="margin-top:16px;">
                        <div class="hp-composer-top">
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
                @endif

                @forelse ($posts as $post)
                    <article class="hp-card hp-post" style="margin-top:16px;">
                        <div class="hp-post-head">
                            <div class="hp-post-meta">
                                <div class="hp-post-name">{{ $post->user->name }}</div>
                                <div class="hp-post-time">{{ $post->created_at->diffForHumans() }}</div>
                            </div>
                            <button class="hp-post-more">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg>
                            </button>
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
                                <span class="like-count" data-post-id="{{ $post->id }}">{{ $post->likes->count() }}</span>
                            </div>
                            <div>
                                <span class="comment-count" data-post-id="{{ $post->id }}">{{ $post->comments->count() }}</span> comments ·
                                <span class="share-count" data-post-id="{{ $post->id }}">{{ $post->shares->count() }}</span> shares
                            </div>
                        </div>

                        <div class="hp-post-actions">
                            <button
                                type="button"
                                class="hp-post-action like-btn {{ $post->isLikedBy(auth()->id()) ? 'hp-liked' : '' }}"
                                data-post-id="{{ $post->id }}"
                                data-like-url="{{ route('posts.like', $post->id) }}"
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M12 21s-7-4.5-9.5-9C1 8 3 4 7 4c2 0 4 1.5 5 3 1-1.5 3-3 5-3 4 0 6 4 4.5 8-2.5 4.5-9.5 9-9.5 9z"/></svg>
                                <span class="like-text">{{ $post->isLikedBy(auth()->id()) ? 'Liked' : 'Like' }}</span>
                            </button>

                            <button class="hp-post-action">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 01-4.7 7.6 8.38 8.38 0 01-3.8.9 8.5 8.5 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"/></svg>
                                Comment
                            </button>

                            <button
                                type="button"
                                class="hp-post-action share-btn {{ $post->isSharedBy(auth()->id()) ? 'hp-liked' : '' }}"
                                data-post-id="{{ $post->id }}"
                                data-share-url="{{ route('posts.share', $post->id) }}"
                                {{ $post->isSharedBy(auth()->id()) ? 'disabled' : '' }}
                            >
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M4 12v7a1 1 0 001 1h14a1 1 0 001-1v-7M16 6l-4-4-4 4M12 2v14"/></svg>
                                <span class="share-text">{{ $post->isSharedBy(auth()->id()) ? 'Shared' : 'Share' }}</span>
                            </button>
                        </div>

                        <div class="comments-list" id="comments-{{ $post->id }}">
                            @foreach ($post->comments as $comment)
                                <div class="comment-item">
                                    <div class="comment-bubble">
                                        <div class="comment-author">{{ $comment->user->name }}</div>
                                        <div class="comment-text">{{ $comment->content }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="hp-comment-row">
                            <input
                                type="text"
                                class="hp-comment-input comment-input-field"
                                placeholder="Write a comment..."
                                data-post-id="{{ $post->id }}"
                                data-comment-url="{{ route('comments.store', $post->id) }}"
                            >
                        </div>
                    </article>
                @empty
                    <div class="hp-card" style="padding:40px; text-align:center; margin-top:16px; color:#64748B;">
                        No posts yet.
                    </div>
                @endforelse
            </div>

            <!-- FRIENDS TAB -->
            <div class="pv-tab-content" id="pv-tab-friends" style="display:none;">
                <div class="pv-friends-grid">
                    @forelse ($friends as $friend)
                        <a href="{{ route('profile.show', $friend->id) }}" class="pv-friend-card hp-card">
                            <div class="pv-friend-name">{{ $friend->name }}</div>
                        </a>
                    @empty
                        <div class="hp-card" style="padding:30px; text-align:center; color:#64748B; grid-column:1/-1;">
                            No friends yet.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    @if ($isOwnProfile)
        @include('create_post_modal')
    @endif
</x-app-layout>