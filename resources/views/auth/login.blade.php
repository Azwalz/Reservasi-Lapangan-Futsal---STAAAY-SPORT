<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl px-8 py-10 mx-auto">

        <!-- Logo Tengah -->
        <div class="text-center mb-8">
            <img src="{{ asset('assets/landing/logo.png') }}" alt="Logo" class="mx-auto w-24 h-24 object-contain" />
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6 text-center text-sm text-pinkstrong" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block text-gray-700 font-semibold mb-1" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="you@example.com"
                    class="w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 placeholder-gray-400
                           focus:outline-none focus:ring-2 focus:ring-pinkstrong focus:border-pinkstrong transition"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-pinkstrong" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="block text-gray-700 font-semibold mb-1" />
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    class="w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 placeholder-gray-400
                           focus:outline-none focus:ring-2 focus:ring-pinkstrong focus:border-pinkstrong transition"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-pinkstrong" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center space-x-2">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="rounded border-pinkstrong text-pinkstrong focus:ring-pinkstrong focus:ring-2"
                />
                <label for="remember_me" class="text-gray-700 text-sm select-none">{{ __('Remember me') }}</label>
            </div>

            <!-- Forgot password + Login -->
            <div class="flex items-center justify-between">
                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm text-pinkstrong hover:underline"
                    >
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-primary-button
                    class="bg-pinkstrong text-white font-semibold px-6 py-3 rounded-md hover:bg-pinklight
                           focus:outline-none focus:ring-2 focus:ring-pinklight transition"
                >
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
