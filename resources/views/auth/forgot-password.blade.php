<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl px-8 py-10 mx-auto">

        <div class="mb-4 text-sm text-gray-700">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4 text-pinkstrong" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" class="block text-gray-700 font-semibold mb-1" />
                <x-text-input 
                    id="email" 
                    class="block mt-1 w-full px-4 py-3 rounded-md border border-gray-300 text-gray-900 placeholder-gray-400
                           focus:outline-none focus:ring-2 focus:ring-pinkstrong focus:border-pinkstrong transition" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                />
                <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-pinkstrong" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="bg-pinkstrong text-white font-semibold px-6 py-3 rounded-md hover:bg-pinklight
                    focus:outline-none focus:ring-2 focus:ring-pinklight transition">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
