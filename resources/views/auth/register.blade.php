<x-auth-card>
    <h1 class="mb-4 text-3xl font-semibold">Welcome to {{ config('app.name') }}</h1>
    <p class="mb-8 text-gray-700">Already have an account? <x-link href="{{ route('login') }}">Sign in.</x-link></p>

    <!-- Name -->
    <x-form-group>
        <x-label for="name">Name</x-label>
        <x-input name="name" autofocus wire:model.defer="name" />
        <x-form-error name="name" />
    </x-form-group>

    <!-- Email -->
    <x-form-group>
        <x-label for="email">Email</x-label>
        <x-input name="email" wire:model.defer="email" />
        <x-form-error name="email" />
    </x-form-group>

    <!-- Password -->
    <x-form-group>
        <x-label for="password">Password</x-label>
        <x-input name="password" wire:model.defer="password" />
        <x-form-error name="password" />
    </x-form-group>

    <!-- Confirm Password -->
    <x-form-group>
        <x-label for="password_confirmation">Confirm Password</x-label>
        <x-input type="password" name="password_confirmation" wire:model.defer="password_confirmation" />
        <x-form-error name="password_confirmation" />
    </x-form-group>

    <!-- Submit Button -->
    <x-card-footer>
        <x-button wire:click="register">Register</x-button>
    </x-card-footer>
</x-auth-card>
