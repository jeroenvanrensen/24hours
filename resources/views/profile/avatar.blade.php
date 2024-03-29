<div>
    <x-navbar />

    <x-profile-section>
        <x-slot name="title">Avatar</x-slot>
        <x-slot name="description">Update your profile picture or use the default one.</x-slot>

        <x-alert text="Uploading image..." wire:loading.flex wire:target="avatar">
            <x-slot name="icon"><x-heroicon-s-exclamation-circle /></x-slot>
        </x-alert>
    
        @if($avatar)
        <x-alert color="green" text="Image uploaded!">
            <x-slot name="icon"><x-heroicon-s-check-circle /></x-slot>
        </x-alert>
        @endif

        <!-- Avatar -->
        <x-form-group>
            <x-label for="avatar">Upload your avatar</x-label>
            <x-input type="file" name="avatar" wire:model.defer="avatar" />
            <x-form-error name="avatar" />
        </x-form-group>

        <!-- Submit button -->
        <x-card-footer>
            @if(session()->has('success'))
                <span class="text-gray-600 dark:text-gray-300">{{ session()->get('success') }}</span>
            @endif
            
            <x-button wire:click="remove" secondary>Reset to default</x-button>
            <x-button wire:click="upload">Save</x-button>
        </x-card-footer>
    </x-profile-section>
</div>
