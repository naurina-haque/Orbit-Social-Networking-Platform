<div class="ep-header">
    <h2 class="ep-title">Delete Account</h2>
    <p class="ep-desc">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
</div>

<button
    type="button"
    class="ep-btn-danger"
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
>Delete Account</button>

<div
    x-data="{
        show: false,
        focusables() {
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
            return [...$el.querySelectorAll(selector)].filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            setTimeout(() => firstFocusable().focus(), 100)
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null"
    x-on:close-modal.window="$event.detail == 'confirm-user-deletion' ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="ep-modal-mask"
    style="display: none;"
>
    <div class="ep-modal" x-on:click.self="show = false">
        <h2 class="ep-modal-title">Are you sure you want to delete your account?</h2>
        <p class="ep-modal-desc">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="ep-field">
                <label for="password" class="ep-label">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="ep-input"
                    placeholder="Password"
                >
                @if ($errors->userDeletion->get('password'))
                    <ul class="ep-error">
                        @foreach ((array) $errors->userDeletion->get('password') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="ep-modal-actions">
                <button type="button" class="ep-btn-secondary" x-on:click="show = false; $dispatch('close')">Cancel</button>
                <button type="submit" class="ep-btn-danger">Delete Account</button>
            </div>
        </form>
    </div>
</div>
