<x-profile-section>
    <x-slot name="title">Update Password</x-slot>
    <x-slot name="description">Ensure your account is using a long, random password to stay secure.</x-slot>

    <x-slot name="card">
        <!-- Old Password -->
        <x-form-group>
            <x-label for="old_password">Old Password</x-label>
            <x-input type="password" name="old_password" id="old_password" wire:model="old_password" />
            <x-form-error name="old_password" />
        </x-form-group>

        <!-- New Password -->
        <x-form-group>
            <x-label for="password">New Password</x-label>
            <x-input type="password" name="password" id="password" wire:model="password" />
            <x-form-error name="password" />
        </x-form-group>

        <!-- Confirm New Password -->
        <x-form-group>
            <x-label for="password_confirmation">Confirm New Password</x-label>
            <x-input type="password" name="password_confirmation" id="password_confirmation" wire:model="password_confirmation" />
            <x-form-error name="password_confirmation" />
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
