<x-guest-layout>

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">

        <!-- Logo -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-indigo-600">Orbit</h1>
            <p class="text-gray-500 mt-2">Connect. Share. Discover.</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-5">
                <x-input-label for="email" :value="__('Email Address')" />
                <x-text-input
                    id="email"
                    class="bg-white block mt-2 w-full rounded-lg"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Enter your email"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-5">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input
                    id="password"
                    class="block mt-2 w-full rounded-lg"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between mb-6">
                <label class="inline-flex items-center">
                    <input
                        id="remember_me"
                        type="checkbox"
                        name="remember"
                        class="rounded border-gray-300 text-indigo-600"
                    >
                    <span class="ml-2 text-sm text-gray-600">
                        Remember Me
                    </span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                        class="text-sm text-indigo-600 hover:underline">
                        Forgot Password?
                    </a>
                @endif
            </div>

            <!-- Login Button -->
            <button
                type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-lg font-semibold transition">
                Login
            </button>

            <!-- Register -->
            <p class="text-center text-gray-600 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}"
                    class="text-indigo-600 font-semibold hover:underline">
                    Register
                </a>
            </p>

        </form>

    </div>

</x-guest-layout>
