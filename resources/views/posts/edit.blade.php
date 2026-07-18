<x-app-layout>
    <div class="ep-page">
        <div class="ep-wrap">
            <div class="ep-card">
                <div class="ep-header">
                    <h2 class="ep-title">Edit Post</h2>
                    <p class="ep-desc">Update your post content below.</p>
                </div>

                <form method="POST" action="{{ route('posts.update', $post->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="ep-field">
                        <label for="content" class="ep-label">Content</label>
                        <textarea
                            id="content"
                            name="content"
                            class="ep-textarea"
                            rows="6"
                            required
                        >{{ old('content', $post->content) }}</textarea>
                        @if ($errors->get('content'))
                            <ul class="ep-error">
                                @foreach ((array) $errors->get('content') as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="ep-actions">
                        <a href="{{ route('home') }}" class="ep-btn-secondary">Cancel</a>
                        <button type="submit" class="ep-btn">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
