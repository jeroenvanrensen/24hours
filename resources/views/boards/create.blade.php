<div>
    <x-modal>
        <x-slot name="title">New Board</x-slot>

        <x-forms.group>
            <x-forms.input type="text" name="name" id="name" wire:model.lazy="name" placeholder="Name" />
            <x-forms.error name="name" />
        </x-forms.group>

        <div class="flex items-center justify-end">
            <x-button class="mr-2" @click="showModal = false" secondary>Cancel</x-button>
            <x-button loading="create" wire:click="create">Create</x-button>
        </div>
    </x-modal>
</div>
