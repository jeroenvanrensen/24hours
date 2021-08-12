<div>
    <x-modal name="create-board" title="New Board">
        <x-input type="text" name="name" id="name" wire:model.defer="name" placeholder="Name" />
        <x-form-error name="name" />

        <x-slot name="footer">
            <x-button loading="create" wire:click="create">Create</x-button>
        </x-slot>
    </x-modal>
</div>
