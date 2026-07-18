<x-app-layout>
    <div class="ep-page">
        <div class="ep-wrap">
            <div class="ep-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="ep-card">
                @include('profile.partials.update-password-form')
            </div>

            <div class="ep-card">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
