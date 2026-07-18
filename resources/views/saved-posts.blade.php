<x-app-layout>
    <div class="hp-body">
        <div class="hp-layout">

            @include('leftsidebar')

            <main>
                <section class="hp-card" style="padding:20px; margin-bottom:16px;">
                    <h2 style="font-size:22px;font-weight:700;">Saved Posts</h2>
                    <p style="margin-top:8px;color:#64748B;">Posts you have saved for later.</p>
                </section>

                @forelse ($savedPosts as $post)
                    @include('post-card', ['post' => $post])
                @empty
                    <div class="hp-card" style="padding:20px; text-align:center; color:#64748B;">
                        No saved posts yet.
                    </div>
                @endforelse
            </main>

            @include('rightsidebar')
        </div>
    </div>
</x-app-layout>