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

                    <form action="{{ route('notifications.markAllRead') }}" method="POST" style="margin-bottom:20px;">
                        @csrf
                        <button class="mark-all-btn">
                            Mark All as Read
                        </button>
                    </form>

                    @foreach($notifications as $notification)

                        <div class="notification-card {{ $notification->read ? '' : 'unread' }}">

                            <div class="notification-content">

                                <h4>{{ $notification->fromUser->name }}</h4>

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

    </div>
</div>

</x-app-layout>