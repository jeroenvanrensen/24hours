<x-profile.section>
    <x-slot name="icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </x-slot>

    <x-slot name="title">Profile Information</x-slot>

    <x-slot name="description">Update your account's profile information and email address.</x-slot>

    <x-slot name="card">
        <!-- Name -->
        <x-forms.group>
            <x-forms.label for="name">Name</x-forms.label>
            <x-forms.input type="text" name="name" id="name" wire:model="name" />
            <x-forms.error name="name" />
        </x-forms.group>

        <!-- Email -->
        <x-forms.group>
            <x-forms.label for="email">Email</x-forms.label>
            <x-forms.input type="text" name="email" id="email" wire:model="email" />
            <x-forms.error name="email" />
        </x-forms.group>

        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            @if(session()->has('success'))
                <span class="text-gray-600 dark:text-gray-300">{{ session()->get('success') }}</span>
            @endif

            <x-button class="ml-4" wire:click="update" loading="update">Save</x-button>
        </div>
    </x-slot>
</x-profile.section>
