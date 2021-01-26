<div>
    <h1 class="mb-6 text-3xl">New Board</h1>

    <!-- Name -->
    <x-forms.group>
        <x-forms.label for="name">Name</x-forms.label>
        <x-forms.input type="text" name="name" id="name" wire:model.lazy="name" />
        <x-forms.error name="name" />
    </x-forms.group>

    <x-button wire:click="create">Create Board</x-button>
</div>
