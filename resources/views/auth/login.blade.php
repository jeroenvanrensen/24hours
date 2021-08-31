<x-auth-card>
    <h1 class="mb-4 text-3xl font-semibold">Sign in to {{ config('app.name') }}</h1>
    <p class="mb-8 text-gray-700 dark:text-gray-200">Don't have an account yet? <x-link href="{{ route('register') }}">Create one.</x-link></p>

    <!-- Email -->
    <x-form-group>
        <x-label for="email">Email</x-label>
        <x-input name="email" autofocus wire:model.defer="email" />
        <x-form-error name="email" />
    </x-form-group>

    <!-- Password -->
    <x-form-group>
        <x-label for="password">Password</x-label>
        <x-input name="password" autofocus wire:model.defer="password" />
        <x-form-error name="password" />
    </x-form-group>

    <!-- Submit Button -->
    <x-card-footer>
        <x-link :href="route('password.request', ['email' => $email])" class="text-sm">Forgot your password?</x-link>
        <x-button wire:click="login">Sign In</x-button>
    </x-card-footer>
</x-auth-card>
