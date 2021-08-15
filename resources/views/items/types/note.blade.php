<x-card
    :link="route('notes.edit', $item)"
    :title="$item->title"
    :description="$item->updated_at->format('F j, Y')"
    deleteButton="delete-note-{{ $item->id }}"
>
    <x-slot name="icon">
        <x-heroicon-o-pencil-alt class="w-20 h-20" />
    </x-slot>
    
    <x-slot name="modal">
        <x-modal name="delete-note-{{ $item->id }}" title="Delete note">
            <p class="mb-4 text-gray-700">Are you sure you want to delete this note?</p>

            <x-slot name="footer">
                <x-button wire:click="deleteNote({{ $item->id }})">Delete</x-button>
            </x-slot>
        </x-modal>
    </x-slot>
</x-card>
