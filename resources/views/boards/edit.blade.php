<div>
    <x-heading>Edit Board</x-heading>

    <div class="max-w-2xl mx-auto">
        <!-- Name -->
        <x-forms.group>
            <x-forms.label for="board.name">Name</x-forms.label>
            <x-forms.input type="text" name="board.name" id="board.name" wire:model.lazy="board.name" />
            <x-forms.error name="board.name" />
        </x-forms.group>

        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            <x-button class="block mr-2" secondary link href="{{ route('boards.show', $board) }}">Cancel</x-button>
            <x-button wire:click="update" loading="update">Update</x-button>
        </div>
    </div>
</div>
