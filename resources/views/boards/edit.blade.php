<div
    x-data="{ showModal: false }"
    class="max-w-2xl mx-auto"
    @keydown.window.escape="if(!showModal) Turbolinks.visit('{{ route('boards.show', $board) }}');"
>
    <x-heading small>Edit Board</x-heading>

    <!-- Name -->
    <x-forms.group>
        <x-forms.label for="board.name">Name</x-forms.label>
        <x-forms.input type="text" name="board.name" id="board.name" wire:model.lazy="board.name" />
        <x-forms.error name="board.name" />
    </x-forms.group>

    <!-- Submit Button -->
    <div class="flex items-center justify-end">
        <button @click="showModal = true" class="text-gray-500 hover:text-red-700 focus:text-red-700 focus:outline-none">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
        <x-button class="block ml-3 mr-2" secondary link href="{{ route('boards.show', $board) }}">Cancel</x-button>
        <x-button wire:click="update" loading="update">Update</x-button>
    </div>

    <!-- Delete modal -->
    <x-modal>
        <x-slot name="title">Delete Board</x-slot>

        <p class="mb-6">Are you sure you want to delete this board? This will delete all notes and links that belong to this board too.</p>
        <p class="mb-6"><strong>{{ $board->name }}</strong></p>

        <div class="flex items-center justify-end">
            <x-button secondary class="mr-2" @click="showModal = false">Cancel</x-button>
            <x-button wire:click="destroy" color="red" loading="destroy">Delete</x-button>
        </div>
    </x-modal>
</div>
