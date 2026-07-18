<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">

            <div class="auth-logo">
                <h1>Orbit</h1>
                <p>Reset your password</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div class="auth-field">
                    <label for="email" class="auth-label">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="auth-input"
                        value="{{ old('email', $request->email) }}"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="Enter your email"
                    >
                    @if ($errors->get('email'))
                        <ul class="auth-error">
                            @foreach ((array) $errors->get('email') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="auth-field">
                    <label for="password" class="auth-label">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="auth-input"
                        required
                        autocomplete="new-password"
                        placeholder="Enter new password"
                    >
                    @if ($errors->get('password'))
                        <ul class="auth-error">
                            @foreach ((array) $errors->get('password') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="auth-field">
                    <label for="password_confirmation" class="auth-label">Confirm Password</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        class="auth-input"
                        required
                        autocomplete="new-password"
                        placeholder="Confirm new password"
                    >
                    @if ($errors->get('password_confirmation'))
                        <ul class="auth-error">
                            @foreach ((array) $errors->get('password_confirmation') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div style="margin-top: 18px;">
                    <button type="submit" class="auth-btn">Reset Password</button>
                </div>

            </form>

        </div>
    </div>
</x-guest-layout>
