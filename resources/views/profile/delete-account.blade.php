<div>
    <x-profile.section>
        <x-slot name="icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </x-slot>

        <x-slot name="title">Delete your account</x-slot>

        <x-slot name="description">This action cannot be undone. This will permanently delete your account, all your boards, all your notes and all your links. Please type your email and password to confirm.</x-slot>

        <x-slot name="card">
            <!-- Email -->
            <x-forms.group>
                <x-forms.label for="email">Email</x-forms.label>
                <x-forms.input type="text" name="email" id="email" wire:model.lazy="email" />
                <x-forms.error name="email" />
            </x-forms.group>

            <!-- Password -->
            <x-forms.group>
                <x-forms.label for="password">Password</x-forms.label>
                <x-forms.input type="password" name="password" id="password" wire:model.lazy="password" />
                <x-forms.error name="password" />
            </x-forms.group>

            <!-- Submit Button -->
            <div class="flex items-center justify-end">
                <x-button color="red" wire:click="destroy" loading="destroy">Yes, delete my account</x-button>
            </div>
        </x-slot>
    </x-profile.section>
</div>
