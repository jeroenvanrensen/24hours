<div x-data @keydown.window.escape="!$store.modalOpen && Turbolinks.visit('{{ route('boards.show', $note->board) }}');">
    <x-navbar />

    <x-container>
        <div class="mb-10">
            <x-button link secondary href="{{ route('boards.show', $note->board) }}">Back</x-button>
        </div>

        <textarea
            class="w-full px-4 py-3 border border-gray-200 rounded-md shadow-sm focus:border-gray-300 focus:outline-none"
            autofocus
            wire:model="body"
        ></textarea>
    </x-container>
</div>
