<x-profile-section>
    <x-slot name="title">Profile Information</x-slot>
    <x-slot name="description">Update your account's profile information and email address.</x-slot>

    <x-slot name="card">
        <!-- Name -->
        <x-form-group>
            <x-label for="name">Name</x-label>
            <x-input type="text" name="name" id="name" wire:model="name" />
            <x-form-error name="name" />
        </x-form-group>

        <!-- Email -->
        <x-form-group>
            <x-label for="email">Email</x-label>
            <x-input type="text" name="email" id="email" wire:model="email" />
            <x-form-error name="email" />
        </x-form-group>

        <!-- Submit Button -->
        <x-card-footer>
            @if(session()->has('success'))
                <span class="text-gray-600 dark:text-gray-300">{{ session()->get('success') }}</span>
            @endif

            <x-button class="ml-4" wire:click="update" loading="update">Save</x-button>
        </x-card-footer>
    </x-slot>
</x-profile-section>
