<div>
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
