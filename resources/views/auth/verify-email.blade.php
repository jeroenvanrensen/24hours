<div>
    <x-auth.card>
        <h1 class="text-2xl mb-6">Verify Email</h1>

        <p class="mb-6">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>

        <div class="flex justify-end items-center">
            @if(session()->has('success'))
                <span class="text-sm text-gray-600">{{ session()->get('success') }}</span>
            @endif

            <x-button class="ml-4" wire:click="request">Resend Verification Email</x-button>
        </div>
    </x-auth.card>
</div>
