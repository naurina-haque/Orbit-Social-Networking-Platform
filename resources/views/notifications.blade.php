<x-app-layout>

<div class="hp-body">
    <div class="hp-layout">

        {{-- LEFT SIDEBAR --}}
        @include('leftsidebar')

        {{-- CENTER --}}
        <main>

            <div class="hp-card" style="padding:20px">

                <h2 style="font-size:22px;font-weight:700;margin-bottom:20px;">
                    Notifications
                </h2>

                @if($notifications->isEmpty())

                    <div class="notification-empty">
                        No notifications yet.
                    </div>

                @else

                    @foreach($notifications as $notification)

                        <div class="notification-card {{ $notification->read ? '' : 'unread' }}">

                            <a href="{{ route('profile.show', $notification->fromUser->id) }}" style="text-decoration:none; flex-shrink:0;">
                                <span class="hp-avatar-ring xs"><img src="{{ $notification->fromUser->profile_photo ? asset('storage/' . $notification->fromUser->profile_photo) : asset('profileimg.jpg') }}" alt=""></span>
                            </a>

                            <div class="notification-content">

                                <a href="{{ route('profile.show', $notification->fromUser->id) }}" style="text-decoration:none; color:inherit;">
                                    <h4>{{ $notification->fromUser->name }}</h4>
                                </a>

                                <p>{{ $notification->message }}</p>

                                <small>{{ $notification->created_at->diffForHumans() }}</small>

                            </div>

                            @if(!$notification->read)

                                <form action="{{ route('notifications.read',$notification->id) }}" method="POST">
                                    @csrf
                                    <button class="read-btn">
                                        Mark as Read
                                    </button>
                                </form>

                            @endif

                        </div>

                    @endforeach

                @endif

            </div>

        </main>

        {{-- RIGHT SIDEBAR --}}
        @include('rightsidebar')

    </div>
</div>

</x-app-layout>