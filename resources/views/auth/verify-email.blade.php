<x-guest-layout>
    <div class="w-full max-w-md bg-white rounded-xl shadow-xl px-8 py-10 mx-auto">

        <div class="mb-4 text-sm text-gray-700">
            {{ __("Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.") }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button class="bg-pinkstrong text-white font-semibold px-6 py-3 rounded-md hover:bg-pinklight
                    focus:outline-none focus:ring-2 focus:ring-pinklight transition">
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                    class="underline text-sm text-pinkstrong hover:text-pinklight rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pinkstrong">
                    {{ __('Log Out') }}
                </button>
            </form>

        </div>
    </div>
</x-guest-layout>
