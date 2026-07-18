<x-app-layout>

<div class="hp-body">
    <div class="hp-layout">

        {{-- LEFT SIDEBAR --}}
        @include('leftsidebar')

        {{-- RIGHT SIDEBAR --}}

        {{-- CENTER --}}
        <main>

            <div class="hp-card" style="padding:20px">

                <h2 style="font-size:22px;font-weight:700;margin-bottom:20px;">
                    Friend Requests
                </h2>

                @forelse($pendingRequests as $request)

                <div class="fr-item">

                    <div class="fr-left">

                        <span class="hp-avatar-ring">
                            <img src="{{ $request->sender->profile_photo ? asset('storage/' . $request->sender->profile_photo) : asset('profileimg.jpg') }}">
                        </span>

                        <div>

                            <div class="hp-name">
                                {{ $request->sender->name }}
                            </div>

                            <div class="hp-sub">
                                Wants to be your friend
                            </div>

                        </div>

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

    </div>
</div>

</x-app-layout>