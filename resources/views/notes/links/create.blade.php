<div>
    <x-modal>
        <x-slot name="title">Add a link</x-slot>

        <x-forms.group>
            <x-forms.input type="text" name="url" id="url" wire:model.lazy="url" placeholder="Typ or paste a link" />
            <x-forms.error name="url" />
        </x-forms.group>

        <div class="flex items-center justify-end">
            <x-button class="mr-2" @click="showModal = false" secondary>Cancel</x-button>
            <x-button loading="add" wire:click="add">Add</x-button>
        </div>
    </x-modal>
</div>
