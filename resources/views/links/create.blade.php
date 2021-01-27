<div x-show="showModal" class="fixed w-full h-screen inset-0 flex items-center justify-center" style="display: none;" id="add-link-modal">
    <div @click="showModal = false" class="absolute w-full h-full bg-black opacity-25"></div>

    <div class="p-8 z-10 bg-white rounded-lg shadow-lg max-w-xl w-full">
        <h2 class="mb-6 text-xl font-semibold">Add a link</h2>

        <x-forms.group>
            <x-forms.input type="text" name="url" id="url" wire:model.lazy="url" placeholder="Typ or paste a link" />
            <x-forms.error name="url" />
        </x-forms.group>

        <div class="flex items-center justify-end">
            <x-button class="mr-2" @click="showModal = false" secondary>Cancel</x-button>
            <x-button loading="add" wire:click="add">Add</x-button>
        </div>
    </div>
</div>
