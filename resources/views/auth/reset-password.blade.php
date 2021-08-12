<x-auth-card>
    <h1 class="mb-8 text-3xl font-semibold">Reset your password</h1>

    <!-- Email -->
    <x-form-group>
        <x-label for="email">Email</x-label>
        <x-input type="email" name="email" id="email" wire:model="email" />
        <x-form-error name="email" />
    </x-form-group>

    <!-- Password -->
    <x-form-group>
        <x-label for="password">Password</x-label>
        <x-input type="password" name="password" id="password" wire:model="password" autofocus />
        <x-form-error name="password" />
    </x-form-group>

    <!-- Confirm Password -->
    <x-form-group>
        <x-label for="password_confirmation">Confirm Password</x-label>
        <x-input type="password" name="password_confirmation" id="password_confirmation" wire:model="password_confirmation" />
        <x-form-error name="password_confirmation" />
    </x-form-group>

    <!-- Submit button -->
    <x-card-footer>
        <x-button wire:click="update">Reset Password</x-button>
    </x-card-footer>
</x-auth-card>
