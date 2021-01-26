<div>
    <x-auth.card>
        <h1 class="text-2xl mb-6">Reset Password</h1>

        <!-- Email -->
        <x-forms.group>
            <x-forms.label for="email">Email</x-forms.label>
            <x-forms.input type="email" name="email" id="email" wire:model="email" />
            <x-forms.error name="email" />
        </x-forms.group>

        <!-- Password -->
        <x-forms.group>
            <x-forms.label for="password">Password</x-forms.label>
            <x-forms.input type="password" name="password" id="password" wire:model="password" autofocus />
            <x-forms.error name="password" />
        </x-forms.group>

        <!-- Confirm Password -->
        <x-forms.group>
            <x-forms.label for="password_confirmation">Confirm Password</x-forms.label>
            <x-forms.input type="password" name="password_confirmation" id="password_confirmation" wire:model="password_confirmation" />
            <x-forms.error name="password_confirmation" />
        </x-forms.group>

        <div class="flex justify-end">
            <x-button wire:click="update">Reset Password</x-button>
        </div>
    </x-auth.card>
</div>
