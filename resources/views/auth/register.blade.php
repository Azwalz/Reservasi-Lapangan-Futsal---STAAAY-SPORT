<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl px-8 py-10 mx-auto">
        <!-- Logo Tengah -->
        <div class="text-center mb-8">
            <img src="{{ asset('assets/landing/logo.png') }}" alt="Logo" class="mx-auto w-24 h-24 object-contain" />
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-6 text-center text-sm text-pinkstrong" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" class="block text-gray-700 font-semibold mb-1" />
                <x-text-input id="name" class="w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-2 focus:ring-pinkstrong focus:border-pinkstrong transition"
                              type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-pinkstrong" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block text-gray-700 font-semibold mb-1" />
                <x-text-input id="email" class="w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-2 focus:ring-pinkstrong focus:border-pinkstrong transition"
                              type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-pinkstrong" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" class="block text-gray-700 font-semibold mb-1" />
                <x-text-input id="password" class="w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-2 focus:ring-pinkstrong focus:border-pinkstrong transition"
                              type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-pinkstrong" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block text-gray-700 font-semibold mb-1" />
                <x-text-input id="password_confirmation" class="w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 placeholder-gray-400
                                    focus:outline-none focus:ring-2 focus:ring-pinkstrong focus:border-pinkstrong transition"
                              type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-pinkstrong" />
            </div>

            <div class="flex items-center justify-end mt-4 space-x-4">
                <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="bg-pinkstrong text-white font-semibold px-6 py-3 rounded-md hover:bg-pinklight
                    focus:outline-none focus:ring-2 focus:ring-pinklight transition">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
