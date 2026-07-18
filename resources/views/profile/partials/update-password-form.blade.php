<div class="ep-header">
    <h2 class="ep-title">Update Password</h2>
    <p class="ep-desc">Ensure your account is using a long, random password to stay secure.</p>
</div>

<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="ep-field">
        <label for="update_password_current_password" class="ep-label">Current Password</label>
        <input
            id="update_password_current_password"
            name="current_password"
            type="password"
            class="ep-input"
            autocomplete="current-password"
        >
        @if ($errors->updatePassword->get('current_password'))
            <ul class="ep-error">
                @foreach ((array) $errors->updatePassword->get('current_password') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="ep-field">
        <label for="update_password_password" class="ep-label">New Password</label>
        <input
            id="update_password_password"
            name="password"
            type="password"
            class="ep-input"
            autocomplete="new-password"
        >
        @if ($errors->updatePassword->get('password'))
            <ul class="ep-error">
                @foreach ((array) $errors->updatePassword->get('password') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="ep-field">
        <label for="update_password_password_confirmation" class="ep-label">Confirm Password</label>
        <input
            id="update_password_password_confirmation"
            name="password_confirmation"
            type="password"
            class="ep-input"
            autocomplete="new-password"
        >
        @if ($errors->updatePassword->get('password_confirmation'))
            <ul class="ep-error">
                @foreach ((array) $errors->updatePassword->get('password_confirmation') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <div class="ep-actions">
        <button type="submit" class="ep-btn">Save</button>

        @if (session('status') === 'password-updated')
            <p class="ep-success">Saved.</p>
        @endif
    </div>
</form>
