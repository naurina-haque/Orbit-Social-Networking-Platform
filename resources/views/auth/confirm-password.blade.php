<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">

            <div class="auth-logo">
                <h1>Orbit</h1>
                <p>Confirm your password</p>
            </div>

            <div class="auth-hint">
                This is a secure area of the application. Please confirm your password before continuing.
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="auth-field">
                    <label for="password" class="auth-label">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="auth-input"
                        required
                        autocomplete="current-password"
                        placeholder="Enter your password"
                    >
                    @if ($errors->get('password'))
                        <ul class="auth-error">
                            @foreach ((array) $errors->get('password') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div style="margin-top: 18px;">
                    <button type="submit" class="auth-btn">Confirm</button>
                </div>

            </form>

        </div>
    </div>
</x-guest-layout>
