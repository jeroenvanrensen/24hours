<x-auth-card>
    <h1 class="mb-4 text-3xl font-semibold">Verify your email</h1>

    <p class="mb-8 text-gray-700">
        Thanks for signing up! Before getting started, could you verify your email address by
        clicking on the link we just emailed to you? If you didn't receive the email, we will gladly
        send you another.
    </p>

    <x-card-footer>
        @if(session()->has('success'))
        <span class="text-sm text-gray-600">{{ session()->get('success') }}</span>
        @endif

        <x-button class="ml-4" wire:click="request">Resend Verification Email</x-button>
    </x-card-footer>
</x-auth-card>
