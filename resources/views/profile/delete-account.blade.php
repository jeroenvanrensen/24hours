<x-profile-section>
    <x-slot name="title">Delete your account</x-slot>
    <x-slot name="description">This action cannot be undone. This will permanently delete your account, all your boards, all your notes and all your links. Please type your email and password to confirm.</x-slot>

    <x-slot name="card">
        <!-- Email -->
        <x-form-group>
            <x-label for="email">Email</x-label>
            <x-input type="text" name="email" id="email" wire:model.lazy="email" />
            <x-form-error name="email" />
        </x-form-group>

        <!-- Password -->
        <x-form-group>
            <x-label for="password">Password</x-label>
            <x-input type="password" name="password" id="password" wire:model.lazy="password" />
            <x-form-error name="password" />
        </x-form-group>

        <!-- Submit Button -->
        <x-card-footer>
            <x-button color="red" wire:click="destroy" loading="destroy">Yes, delete my account</x-button>
        </x-card-footer>
    </x-slot>
</x-profile-section>
