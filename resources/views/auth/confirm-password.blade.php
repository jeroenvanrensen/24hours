<div>
    <x-auth.card>
        <h1 class="text-2xl mb-6">Confirm Password</h1>

        <p class="mb-6">This is a secure area of the application. Please confirm your password before continuing.</p>

        <!-- Password -->
        <x-forms.group>
            <x-forms.label for="password">Password</x-forms.label>
            <x-forms.input type="password" name="password" id="password" wire:model="password" autofocus />
            <x-forms.error name="password" />
        </x-forms.group>

        <!-- Submit button -->
        <div class="flex justify-end">
            <x-button wire:click="confirm">Confirm</x-button>
        </div>
    </x-auth.card>
</div>
