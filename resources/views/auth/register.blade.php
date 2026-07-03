<x-guest-layout>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-indigo-600">Orbit</h1>
            <p class="text-gray-500 mt-2">Create your account and start connecting.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Full Name')" />
                <x-text-input
                    id="name"
                    class="block mt-2 w-full rounded-lg"
                    type="text"
                    name="name"
                    :value="old('name')"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Enter your full name"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input
                    id="email"
                    class="block mt-2 w-full rounded-lg"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autocomplete="username"
                    placeholder="Enter your email"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input
                    id="password"
                    class="block mt-2 w-full rounded-lg"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    placeholder="Create a password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input
                    id="password_confirmation"
                    class="block mt-2 w-full rounded-lg"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Confirm your password"
                />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Register Button -->
            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-semibold transition">
                Create Account
            </button>

            <!-- Login Link -->
            <p class="text-center text-gray-600 mt-6">
                Already have an account?
                <a href="{{ route('login') }}"
                   class="text-indigo-600 font-semibold hover:underline">
                    Login
                </a>
            </p>

        </form>

    </div>

</x-guest-layout>
