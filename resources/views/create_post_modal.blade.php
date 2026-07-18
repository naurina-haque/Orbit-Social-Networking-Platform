<div class="cp-overlay" id="createPostModal">
    <div class="cp-modal">

        <div class="cp-modal-header">
            <h3>Create Post</h3>
            <a href="#" class="cp-close-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-width="2">
                    <path d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </a>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            

            <div class="cp-user-row">
                <span class="hp-avatar-ring sm"><img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                <div class="cp-user-name">{{ auth()->user()->name }}</div>
            </div>

            <textarea
                name="content"
                class="cp-textarea"
                placeholder="What's on your mind, {{ explode(' ', auth()->user()->name)[0] }}?"
                rows="4"
            ></textarea>

            <div class="cp-add-box">
                <span class="cp-add-label">Add to your post</span>
                <label for="cpImageInput" class="cp-photo-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#14B8A6" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <circle cx="9" cy="10" r="2"/>
                        <path d="M21 16l-5-5-4 4-3-3-4 4"/>
                    </svg>
                </label>
                <input type="file" id="cpImageInput" name="image" accept="image/*" style="display:none;">
            </div>

            <button type="submit" class="cp-submit-btn">Post</button>
        </form>
    </div>
</div>