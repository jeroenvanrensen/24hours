<x-auth-card>
    <h1 class="mb-4 text-3xl font-semibold">Confirm your password</h1>
    <p class="mb-8 text-gray-700">This is a secure area of the application. Please confirm your password before continuing.</p>

    <!-- Password -->
    <x-form-group>
        <x-label for="password">Password</x-label>
        <x-input name="password" autofocus wire:model.defer="password" />
        <x-form-error name="password" />
    </x-form-group>

    <!-- Submit button -->
    <x-card-footer>
        <x-button wire:click="confirm">Confirm</x-button>
    </x-card-footer>
</x-auth-card>
