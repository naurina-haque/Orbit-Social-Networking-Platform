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
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="5" cy="12" r="1.6"/>
                    <circle cx="12" cy="12" r="1.6"/>
                    <circle cx="19" cy="12" r="1.6"/>
                </svg>
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
                                        <!-- Existing comments -->

