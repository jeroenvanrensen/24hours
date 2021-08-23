<x-auth-card>
    <h1 class="mb-4 text-3xl font-semibold">Forgot your password?</h1>
    <p class="mb-8 leading-7 text-gray-700 dark:text-gray-200">Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>

    <!-- Email -->
    <x-form-group>
        <x-label for="email">Email</x-label>
        <x-input name="email" autofocus wire:model.defer="email" />
        <x-form-error name="email" />
    </x-form-group>

    <!-- Submit Button -->
    <x-card-footer>
        @if(session()->has('success'))
            <span class="text-sm text-gray-600 dark:text-gray-200">{{ session()->get('success') }}</span>
        @endif
        @if(session()->has('error'))
            <span class="text-sm font-medium text-red-700 dark:text-red-400 dark:font-normal">{{ session()->get('error') }}</span>
        @endif

        <x-button wire:click="request">Send Link</x-button>
    </x-card-footer>
</x-auth-card>
