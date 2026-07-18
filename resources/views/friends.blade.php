<x-app-layout>

<div class="hp-body">

    <div class="hp-layout">

        {{-- Left Sidebar --}}
        @include('leftsidebar')

        {{-- Center Content --}}
        <main>

            <div class="hp-card friends-page">

                <div class="friends-header">

                    <h2>Friends</h2>

                </div>

                <div class="friends-grid">

                    @forelse($friends as $friend)

                        @php
                            $user = $friend->sender_id == auth()->id()
                                ? $friend->receiver
                                : $friend->sender;
                        @endphp

                        <div class="friend-card">

                            <a href="{{ route('profile.show', $user->id) }}" class="friend-link">

                                <div class="friend-avatar">
                                <img
                                        src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('profileimg.jpg') }}">
                                </div>

                                <div class="friend-info">
                                    <h3>{{ $user->name }}</h3>
                                
                                </div>

                            </a>

                            <form action="{{ route('friends.remove', $friend->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="remove-btn">
                                    Remove Friend
                                </button>
                            </form>

                        </div>

                    @empty

                        <div class="fr-empty">
                            You don't have any friends yet.
                        </div>

                    @endforelse

                </div>

            </div>

        </main>

    </div>

</div>

</x-app-layout>