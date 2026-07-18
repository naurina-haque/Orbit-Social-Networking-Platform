<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">

            <div class="auth-logo">
                <h1>Orbit</h1>
                <p>Connect. Share. Discover.</p>
            </div>

            @if (session('status'))
                <div class="auth-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="auth-field">
                    <label for="email" class="auth-label">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="auth-input"
                        value="{{ old('email') }}"
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

                <div class="auth-actions">
                    <label class="auth-checkbox">
                        <input id="remember_me" type="checkbox" name="remember">
                        Remember Me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:14px; color:#3B5BDB; text-decoration:none; font-weight:600;">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="auth-btn">Login</button>

                <div class="auth-footer">
                    Don't have an account?
                    <a href="{{ route('register') }}">Register</a>
                </div>

            </form>

        </div>
    </div>
</x-guest-layout>
