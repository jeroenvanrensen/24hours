<x-profile.section>
    <x-slot name="icon">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
    </x-slot>

    <x-slot name="title">Update Password</x-slot>

    <x-slot name="description">Ensure your account is using a long, random password to stay secure.</x-slot>

    <x-slot name="card">
        <!-- Old Password -->
        <x-forms.group>
            <x-forms.label for="old_password">Old Password</x-forms.label>
            <x-forms.input type="password" name="old_password" id="old_password" wire:model="old_password" />
            <x-forms.error name="old_password" />
        </x-forms.group>

        <!-- New Password -->
        <x-forms.group>
            <x-forms.label for="password">New Password</x-forms.label>
            <x-forms.input type="password" name="password" id="password" wire:model="password" />
            <x-forms.error name="password" />
        </x-forms.group>

        <!-- Confirm New Password -->
        <x-forms.group>
            <x-forms.label for="password_confirmation">Confirm New Password</x-forms.label>
            <x-forms.input type="password" name="password_confirmation" id="password_confirmation" wire:model="password_confirmation" />
            <x-forms.error name="password_confirmation" />
        </x-forms.group>

        <!-- Submit Button -->
        <div class="flex justify-end items-center">
            @if(session()->has('success'))
                <span class="text-gray-600">{{ session()->get('success') }}</span>
            @endif

            <x-button class="ml-4" wire:click="update" loading="update">Save</x-button>
        </div>
    </x-slot>
</x-profile.section>
