<div>
    <x-modal name="create-link" title="Add a link">
        <x-alert text="Loading..." wire:loading.flex>
            <x-slot name="icon"><x-heroicon-s-exclamation-circle /></x-slot>
        </x-alert>
        
        <x-input type="text" name="url" id="url" wire:model.defer="url" placeholder="Typ or paste a url..." />
        <x-form-error name="url" />

        <x-slot name="footer">
            <x-button loading="add" wire:click="add">Add</x-button>
        </x-slot>
    </x-modal>
</div>
