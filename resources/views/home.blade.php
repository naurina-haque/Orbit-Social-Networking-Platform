<x-app-layout>
    <div class="hp-body">
        <div class="hp-layout">

            <!-- LEFT SIDEBAR -->
            <aside class="hp-sidebar">
                <a href="{{ route('profile.edit') }}" class="hp-profile-shortcut">
                    <span class="hp-avatar-ring "><img src="https://i.pravatar.cc/80?img=12" alt=""></span>
                    <div>
                        <div class="hp-name">{{ auth()->user()->name }}</div>
                        <div class="hp-handle">{{ Str::slug(auth()->user()->name) }}</div>
                    </div>
                </a>

                <div class="hp-divider"></div>

                <a href="{{ route('home') }}" class="hp-nav-item">
                    <span class="hp-ic" style="background:#EAF1FB">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#3B5BDB"><path d="M3 11.5L12 4l9 7.5"/><path d="M5 10v9a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1v-9"/></svg>
                    </span>
                    Home
                </a>
                <a href="#" class="hp-nav-item">
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
                    @if ($pendingRequests->count() > 0)
                        <span class="hp-count-badge">{{ $pendingRequests->count() }}</span>
                    @endif
                </a>
                <a href="#" class="hp-nav-item">
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

            <!-- CENTER FEED -->
            <main>

                <!-- Composer -->
                <section class="hp-card hp-composer">
                    <div class="hp-composer-top">
                        <span class="hp-avatar-ring"><img src="https://i.pravatar.cc/80?img=12" alt=""></span>
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
                    <article class="hp-card hp-post" style="margin-top:16px;">
                        <div class="hp-post-head">
                            <span class="hp-avatar-ring sm"><img src="https://i.pravatar.cc/80?img=12" alt=""></span>
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

                        <!-- Existing comments -->
                        <div class="comments-list" id="comments-{{ $post->id }}">
                            @foreach ($post->comments as $comment)
                                <div class="comment-item">
                                    <span class="hp-avatar-ring xs"><img src="https://i.pravatar.cc/80?img=12" alt=""></span>
                                    <div class="comment-bubble">
                                        <div class="comment-author">{{ $comment->user->name }}</div>
                                        <div class="comment-text">{{ $comment->content }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- New comment input -->
                        <div class="hp-comment-row">
                            <span class="hp-avatar-ring xs"><img src="https://i.pravatar.cc/80?img=12" alt=""></span>
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
                        No posts yet. Be the first to share something!
                    </div>
                @endforelse

            </main>

            <!-- RIGHT SIDEBAR -->
            <aside class="hp-sidebar">
                <div class="hp-card hp-stat-card" style="margin-bottom:16px;">
                    <div>
                        <div class="hp-stat-num">{{ $friendsCount }}</div>
                        <div class="hp-stat-label">Friends</div>
                    </div>
                    <div>
                        <div class="hp-stat-num">{{ $postsCount }}</div>
                        <div class="hp-stat-label">Posts</div>
                    </div>
                </div>

                <div class="hp-right-title">Friend Requests</div>
                <div class="hp-card" style="padding:6px;margin-bottom:16px;" id="friend-requests-box">
                    @forelse ($pendingRequests as $request)
                        <div class="hp-req-item" id="request-{{ $request->id }}">
                            <span class="hp-avatar-ring xs"><img src="https://i.pravatar.cc/80?img=22" alt=""></span>
                            <div class="hp-info">
                                <div class="hp-name">{{ $request->sender->name }}</div>
                                <div class="hp-sub">Wants to be friends</div>
                            </div>
                            <div class="hp-req-actions">
                                <button
                                    type="button"
                                    class="hp-req-btn hp-accept accept-req-btn"
                                    data-request-id="{{ $request->id }}"
                                    data-accept-url="{{ route('friend-request.accept', $request->id) }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"><path d="M5 13l4 4L19 7"/></svg>
                                </button>
                                <button
                                    type="button"
                                    class="hp-req-btn hp-decline decline-req-btn"
                                    data-request-id="{{ $request->id }}"
                                    data-decline-url="{{ route('friend-request.decline', $request->id) }}"
                                >
                                    <svg viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-width="3"><path d="M6 6l12 12M18 6L6 18"/></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div style="padding:14px; text-align:center; color:#64748B; font-size:13px;">No pending requests</div>
                    @endforelse
                </div>

                <div class="hp-right-title">People you may know</div>
                <div class="hp-card" style="padding:6px;">
                    @forelse ($suggestedUsers as $user)
                        <div class="hp-suggest" id="suggest-{{ $user->id }}">
                            <span class="hp-avatar-ring xs"><img src="https://i.pravatar.cc/80?img=51" alt=""></span>
                            <div class="hp-info">
                                <div class="hp-name">{{ $user->name }}</div>
                                <div class="hp-sub">Orbit user</div>
                            </div>
                            <button
                                type="button"
                                class="hp-add-friend-btn add-friend-btn"
                                data-user-id="{{ $user->id }}"
                                data-send-url="{{ route('friend-request.send', $user->id) }}"
                            >
                                Add Friend
                            </button>
                        </div>
                    @empty
                        <div style="padding:14px; text-align:center; color:#64748B; font-size:13px;">No suggestions right now</div>
                    @endforelse
                </div>
            </aside>

        </div>
    </div>
        @include('create_post_modal')
</x-app-layout>