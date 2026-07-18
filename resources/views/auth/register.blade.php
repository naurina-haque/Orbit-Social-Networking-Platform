<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">

            <div class="auth-logo">
                <h1>Orbit</h1>
                <p>Create your account and start connecting.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="auth-field">
                    <label for="name" class="auth-label">Full Name</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        class="auth-input"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="Enter your full name"
                    >
                    @if ($errors->get('name'))
                        <ul class="auth-error">
                            @foreach ((array) $errors->get('name') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="auth-field">
                    <label for="email" class="auth-label">Email Address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="auth-input"
                        value="{{ old('email') }}"
                        required
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
                        placeholder="Create a password"
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
                        placeholder="Confirm your password"
                    >
                    @if ($errors->get('password_confirmation'))
                        <ul class="auth-error">
                            @foreach ((array) $errors->get('password_confirmation') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <button type="submit" class="auth-btn">Create Account</button>

                <div class="auth-footer">
                    Already have an account?
                    <a href="{{ route('login') }}">Login</a>
                </div>

            </form>

        </div>
    </div>
</x-guest-layout>
