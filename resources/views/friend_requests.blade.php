<x-app-layout>

<div class="hp-body">
    <div class="hp-layout">

        {{-- LEFT SIDEBAR --}}
        @include('leftsidebar')

    

        {{-- CENTER --}}
        <main>

            <div class="hp-card" style="padding:20px">

                <h2 style="font-size:22px;font-weight:700;margin-bottom:20px;">
                    Friend Requests
                </h2>

                @forelse($pendingRequests as $request)

                <div class="fr-item">

                    <div class="fr-left">
                        <a href="{{ route('profile.show', $request->sender->id) }}" style="text-decoration:none;">
                            <span class="hp-avatar-ring">
                                <img src="{{ $request->sender->profile_photo ? asset('storage/' . $request->sender->profile_photo) : asset('profileimg.jpg') }}">
                            </span>
                        </a>

                        <a href="{{ route('profile.show', $request->sender->id) }}" style="text-decoration:none;">
                            <div>

                                <div class="hp-name">
                                    {{ $request->sender->name }}
                                </div>

                                <div class="hp-sub">
                                    Wants to be your friend
                                </div>

                            </div>
                        </a>

                    </div>

                    <div class="fr-actions">

                        <form method="POST"
                            action="{{ route('friend-request.accept',$request->id) }}">

                            @csrf

                            <button class="fr-accept">
                                Accept
                            </button>

                        </form>

                        <form method="POST"
                            action="{{ route('friend-request.decline',$request->id) }}">

                            @csrf

                            <button class="fr-decline">
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

                @empty

                <div class="fr-empty">

                    No pending friend requests.

                </div>

                @endforelse

            </div>

        </main>
            {{-- RIGHT SIDEBAR --}}
        @include('rightsidebar')

    </div>
</div>

</x-app-layout>