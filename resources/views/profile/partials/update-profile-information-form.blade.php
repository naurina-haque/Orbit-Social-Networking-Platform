<div class="ep-header">
    <h2 class="ep-title">Profile Information</h2>
    <p class="ep-desc">Update your account's profile information and email address.</p>
</div>

@if (session('error'))
    <div class="ep-error" style="margin-bottom:18px;">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <!-- Name -->
    <div class="ep-field">
        <label for="name" class="ep-label">Name</label>
        <input
            id="name"
            name="name"
            type="text"
            class="ep-input"
            value="{{ old('name', $user->name) }}"
            required
            autofocus
            autocomplete="name"
        >
        @if ($errors->get('name'))
            <ul class="ep-error">
                @foreach ((array) $errors->get('name') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Email -->
    <div class="ep-field">
        <label for="email" class="ep-label">Email</label>
        <input
            id="email"
            name="email"
            type="email"
            class="ep-input"
            value="{{ old('email', $user->email) }}"
            required
            autocomplete="username"
        >
        @if ($errors->get('email'))
            <ul class="ep-error">
                @foreach ((array) $errors->get('email') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Bio -->
    <div class="ep-field">
        <label for="bio" class="ep-label">Bio</label>
        <textarea
            id="bio"
            name="bio"
            class="ep-textarea"
            rows="4"
        >{{ old('bio', $user->bio) }}</textarea>
        @if ($errors->get('bio'))
            <ul class="ep-error">
                @foreach ((array) $errors->get('bio') as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Education & City -->
    <div class="ep-photo-grid">
        <div class="ep-field">
            <label for="education" class="ep-label">Education</label>
            <input
                id="education"
                name="education"
                type="text"
                class="ep-input"
                value="{{ old('education', $user->education) }}"
                placeholder="e.g. BSc in Computer Science"
            >
            @if ($errors->get('education'))
                <ul class="ep-error">
                    @foreach ((array) $errors->get('education') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="ep-field">
            <label for="city" class="ep-label">City</label>
            <input
                id="city"
                name="city"
                type="text"
                class="ep-input"
                value="{{ old('city', $user->city) }}"
                placeholder="e.g. Dhaka"
            >
            @if ($errors->get('city'))
                <ul class="ep-error">
                    @foreach ((array) $errors->get('city') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Photos -->
    <div class="ep-photo-grid">
        <div class="ep-field">
            <label for="profile_photo" class="ep-label">Profile Photo</label>
            <input
                id="profile_photo"
                name="profile_photo"
                type="file"
                class="ep-file"
                accept="image/*"
            >

            @if ($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile photo preview" class="ep-preview ep-preview-avatar">
            @endif

            @if ($errors->get('profile_photo'))
                <ul class="ep-error">
                    @foreach ((array) $errors->get('profile_photo') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="ep-field">
            <label for="cover_photo" class="ep-label">Cover Photo</label>
            <input
                id="cover_photo"
                name="cover_photo"
                type="file"
                class="ep-file"
                accept="image/*"
            >

            @if ($user->cover_photo)
                <img src="{{ asset('storage/' . $user->cover_photo) }}" alt="Cover photo preview" class="ep-preview ep-preview-cover">
            @endif

            @if ($errors->get('cover_photo'))
                <ul class="ep-error">
                    @foreach ((array) $errors->get('cover_photo') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <!-- Save Button -->
    <div class="ep-actions">
        <button type="submit" class="ep-btn">Save</button>

        @if (session('status') === 'profile-updated')
            <p class="ep-success">Saved Successfully!</p>
        @endif
    </div>
</form>
