<x-app-layout>
    <div class="hp-body">
        <div class="pv-container">

            <!-- Cover + Profile Header -->
            <div class="pv-cover">
                @if ($user->cover_photo)
                    <img src="{{ asset('storage/' . $user->cover_photo) }}" alt="Cover photo" class="pv-cover-image">
                @else
                    <div class="pv-cover-gradient"></div>
                @endif
            </div>

            <div class="pv-header hp-card">
                <div class="pv-avatar-wrap">
                    <div class="pv-avatar {{ $user->profile_photo ? '' : 'pv-avatar-fallback' }}">
                        @if ($user->profile_photo)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="{{ $user->name }}">
                        @else
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('profileimg.jpg') }}" alt="{{ $user->name }}">
                        @endif
                    </div>
                </div>

                <div class="pv-header-info">
                    <h1 class="pv-name">{{ $user->name }}</h1>
                    @if ($user->bio)
                        <p class="pv-bio">{{ $user->bio }}</p>
                    @endif

                    <div class="pv-details">
                        @if ($user->education)
                            <div class="pv-detail-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c0 2 6 3 6 3s6-1 6-3v-5"/></svg>
                                <span>{{ $user->education }}</span>
                            </div>
                        @endif
                        @if ($user->city)
                            <div class="pv-detail-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span>{{ $user->city }}</span>
                            </div>
                        @endif
                    </div>

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
                <button type="button" class="pv-tab" data-tab="saved">Saved ({{ $savedPostsCount }})</button>
            </div>

            <!-- POSTS TAB -->
            <div class="pv-tab-content" id="pv-tab-posts">

                @if ($isOwnProfile)
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
                @endif

                @forelse ($posts as $post)
                    <article class="hp-card hp-post" style="margin-top:16px;">
                        <div class="hp-post-head">
                            <span class="hp-avatar-ring sm">
                                <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : asset('profileimg.jpg') }}" alt="">
                            </span>

                            <div class="hp-post-meta">
                                <div class="hp-post-name">{{ $post->user->name }}</div>
                                <div class="hp-post-time">{{ $post->created_at->diffForHumans() }}</div>
                            </div>

                            <div class="hp-post-menu" data-post-menu>
                                <button type="button" class="hp-post-more" data-post-menu-button aria-expanded="false" aria-label="Post actions">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg>
                                </button>

                                <div class="hp-dropdown" data-post-menu-dropdown>
                                    <form action="{{ route('posts.save', $post->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            {{ $post->isSavedBy(auth()->id()) ? 'Unsave Post' : 'Save Post' }}
                                        </button>
                                    </form>

                                    @if ($post->user_id === auth()->id())
                                        <a href="{{ route('posts.edit', $post->id) }}" class="dropdown-item">Edit Post</a>

                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item delete-btn">Delete Post</button>
                                        </form>
                                    @endif
                                </div>
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
                                <div class="comment-item" data-comment-id="{{ $comment->id }}">
                                    <span class="hp-avatar-ring xs"><img src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                                    <div class="comment-bubble">
                                        <div class="comment-header">
                                            <div class="comment-author">{{ $comment->user->name }}</div>
                                            @if ($comment->user_id === auth()->id() || $post->user_id === auth()->id())
                                                <button type="button" class="comment-delete-btn" data-delete-url="{{ route('comments.destroy', $comment->id) }}" data-comment-id="{{ $comment->id }}" data-post-id="{{ $post->id }}">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="comment-text">{{ $comment->content }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="hp-comment-row">
                            <span class="hp-avatar-ring xs"><img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                            <input
                                type="text"
                                class="hp-comment-input comment-input-field"
                                placeholder="Write a comment..."
                                data-post-id="{{ $post->id }}"
                                data-comment-url="{{ route('comments.store', $post->id) }}"
                            >
                            <button type="button" class="comment-send-btn" data-post-id="{{ $post->id }}" data-comment-url="{{ route('comments.store', $post->id) }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                </svg>
                            </button>
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
                            <div class="pv-friend-avatar">
                                <img src="{{ $friend->profile_photo ? asset('storage/' . $friend->profile_photo) : asset('profileimg.jpg') }}" alt="{{ $friend->name }}">
                            </div>
                            <div class="pv-friend-name">{{ $friend->name }}</div>
                        </a>
                    @empty
                        <div class="hp-card" style="padding:30px; text-align:center; color:#64748B; grid-column:1/-1;">
                            No friends yet.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- SAVED POSTS TAB -->
            <div class="pv-tab-content" id="pv-tab-saved" style="display:none;">
                @forelse ($savedPosts as $post)
                    <article class="hp-card hp-post" style="margin-top:16px;">
                        <div class="hp-post-head">
                            <span class="hp-avatar-ring sm">
                                <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : asset('profileimg.jpg') }}" alt="">
                            </span>

                            <div class="hp-post-meta">
                                <div class="hp-post-name">{{ $post->user->name }}</div>
                                <div class="hp-post-time">{{ $post->created_at->diffForHumans() }}</div>
                            </div>

                            <div class="hp-post-menu" data-post-menu>
                                <button type="button" class="hp-post-more" data-post-menu-button aria-expanded="false" aria-label="Post actions">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg>
                                </button>

                                <div class="hp-dropdown" data-post-menu-dropdown>
                                    <form action="{{ route('posts.save', $post->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            {{ $post->isSavedBy(auth()->id()) ? 'Unsave Post' : 'Save Post' }}
                                        </button>
                                    </form>

                                    @if ($post->user_id === auth()->id())
                                        <a href="{{ route('posts.edit', $post->id) }}" class="dropdown-item">Edit Post</a>

                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item delete-btn">Delete Post</button>
                                        </form>
                                    @endif
                                </div>
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

                            <button class="hp-post-action" type="button">
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
                                <div class="comment-item" data-comment-id="{{ $comment->id }}">
                                    <span class="hp-avatar-ring xs"><img src="{{ $comment->user->profile_photo ? asset('storage/' . $comment->user->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                                    <div class="comment-bubble">
                                        <div class="comment-header">
                                            <div class="comment-author">{{ $comment->user->name }}</div>
                                            @if ($comment->user_id === auth()->id() || $post->user_id === auth()->id())
                                                <button type="button" class="comment-delete-btn" data-delete-url="{{ route('comments.destroy', $comment->id) }}" data-comment-id="{{ $comment->id }}" data-post-id="{{ $post->id }}">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="comment-text">{{ $comment->content }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="hp-comment-row">
                            <span class="hp-avatar-ring xs"><img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                            <input
                                type="text"
                                class="hp-comment-input comment-input-field"
                                placeholder="Write a comment..."
                                data-post-id="{{ $post->id }}"
                                data-comment-url="{{ route('comments.store', $post->id) }}"
                            >
                            <button type="button" class="comment-send-btn" data-post-id="{{ $post->id }}" data-comment-url="{{ route('comments.store', $post->id) }}">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
                                </svg>
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="hp-card" style="padding:40px; text-align:center; margin-top:16px; color:#64748B;">
                        No saved posts yet.
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    @if ($isOwnProfile)
        @include('create_post_modal')
    @endif
</x-app-layout>