<x-guest-layout>
    <div class="auth-page">
        <div class="auth-card">

            <div class="auth-logo">
                <h1>Orbit</h1>
                <p>Reset your password</p>
            </div>

            <div class="auth-hint">
                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </div>

            @if (session('status'))
                <div class="auth-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="auth-field">
                    <label for="email" class="auth-label">Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        class="auth-input"
                        value="{{ old('email') }}"
                        required
                        autofocus
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

                <div style="margin-top: 18px;">
                    <button type="submit" class="auth-btn">Email Password Reset Link</button>
                </div>

            </form>

        </div>
    </div>
</x-guest-layout>
