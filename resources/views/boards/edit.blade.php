<div x-data @keydown.window.escape="!$store.modalOpen && Turbolinks.visit('{{ route('boards.show', $board) }}')">
    <x-navbar />

    <x-panel>
        <h1 class="mb-8 text-3xl font-semibold">Edit Board</h1>
        
        <x-alert text="Uploading image..." wire:loading.flex wire:target="image">
            <x-slot name="icon"><x-heroicon-s-exclamation-circle /></x-slot>
        </x-alert>
    
        @if($image)
        <x-alert color="green" text="Image uploaded!">
            <x-slot name="icon"><x-heroicon-s-check-circle /></x-slot>
        </x-alert>
        @endif
    
        <!-- Name -->
        <x-form-group>
            <x-label for="board.name">Name</x-label>
            <x-input type="text" name="board.name" id="board.name" wire:model.lazy="board.name" />
            <x-form-error name="board.name" />
        </x-form-group>

        <!-- Image -->
        <x-form-group>
            <x-label for="image">Image</x-label>
            <x-input type="file" name="image" wire:model.defer="image" />
            <x-form-error name="image" />
        </x-form-group>
    
        <!-- Submit Button -->
        <x-card-footer class="flex items-center justify-end">
            <button @click="$dispatch('delete-board')" class="text-gray-500 dark:text-gray-400 hover:text-red-700 dark:hover:text-gray-300 dark:focus:text-gray-300 focus:text-red-700 focus:outline-none">
                <x-heroicon-o-trash class="w-6 h-6" />
            </button>

            <x-button secondary link href="{{ route('boards.show', $board) }}">
                Cancel
            </x-button>

            <x-button wire:click="update">
                Update
            </x-button>
        </x-card-footer>
    
        <!-- Delete modal -->
        <x-modal name="delete-board" title="Delete board">
            <p class="mb-6 text-gray-700 dark:text-gray-200">Are you sure you want to delete this board? This will delete all notes and links that belong to this board too.</p>
            <p class="font-medium dark:text-white">{{ $board->name }}</p>
    
            <x-slot name="footer">
                <x-button wire:click="destroy">Delete</x-button>
            </x-slot>
        </x-modal>
    </x-panel>
</div>
