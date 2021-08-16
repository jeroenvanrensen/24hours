<div>
    <x-alert text="Uploading image..." wire:loading.flex wire:target="image">
        <x-slot name="icon"><x-heroicon-s-exclamation-circle /></x-slot>
    </x-alert>

    @if($image)
    <x-alert color="green" text="Image uploaded!">
        <x-slot name="icon"><x-heroicon-s-check-circle /></x-slot>
    </x-alert>
    @endif

    <x-form-group>
        <x-label>Name</x-label>
        <x-input type="text" name="name" id="name" wire:model.defer="name" />
        <x-form-error name="name" />
    </x-form-group>

    <x-form-group>
        <x-label>Image</x-label>
        <x-input type="file" name="image" id="image" wire:model="image" />
        <x-form-error name="image" />
    </x-form-group>

    <x-slot name="footer">
        <x-button loading="create" wire:click="$emitTo('boards.create', 'create')">Create</x-button>
    </x-slot>
</div>
