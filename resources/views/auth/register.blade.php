<div>
    <x-auth.card>
        <h1 class="text-2xl mb-6">Register</h1>

        <!-- Name -->
        <x-forms.group>
            <x-forms.label for="name">Name</x-forms.label>
            <x-forms.input name="name" id="name" wire:model.lazy="name" autofocus />
            <x-forms.error name="name" />
        </x-forms.group>

        <!-- Email -->
        <x-forms.group>
            <x-forms.label for="email">Email</x-forms.label>
            <x-forms.input type="email" name="email" id="email" wire:model.lazy="email" />
            <x-forms.error name="email" />
        </x-forms.group>

        <!-- Password -->
        <x-forms.group>
            <x-forms.label for="password">Password</x-forms.label>
            <x-forms.input type="password" name="password" id="password" wire:model.lazy="password" />
            <x-forms.error name="password" />
        </x-forms.group>

        <!-- Confirm Password -->
        <x-forms.group>
            <x-forms.label for="password_confirmation">Confirm Password</x-forms.label>
            <x-forms.input type="password" name="password_confirmation" id="password_confirmation" wire:model.lazy="password_confirmation" />
            <x-forms.error name="password_confirmation" />
        </x-forms.group>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <x-button wire:click="register">Register</x-button>
        </div>
    </x-auth.card>
</div>
