<div x-data="{ showDropup: false, showModal: false }">
    <x-heading>
        {{ $board->name }}

        <!-- Edit button -->
        @can('edit', $board)
            <a href="{{ route('boards.edit', $board) }}" class="block ml-4 p-2 bg-gray-200 hover:bg-gray-300 focus:bg-gray-300 focus:outline-none rounded-full">
                <svg class="w-4 h-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
            </a>
        @endcan
    </x-heading>

    <!-- Show all items -->
    <livewire:items.index :board="$board" />

    <!-- Add link dropup -->
    <button x-show="showDropup" @click="showModal = true" class="fixed bottom-36 right-4 md:bottom-48 md:right-12 p-4 bg-gray-400 hover:bg-gray-500 rounded-full transition transform focus:outline-none focus:bg-gray-500 focus:ring ring-gray-400 text-white" x-transition:enter="delay-300 ease-out duration-300" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-out duration-300" x-transition:leave-start="opaicty-100 scale-100" x-transition:leave-end="opacity-0 scale-50">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
        </svg>
    </button>

    <!-- Create note dropup -->
    <button x-show="showDropup" wire:click="createNote" class="fixed bottom-20 right-4 md:bottom-32 md:right-12 p-4 bg-gray-400 hover:bg-gray-500 rounded-full transition transform focus:outline-none focus:bg-gray-500 focus:ring ring-gray-400 text-white" x-transition:enter="delay-150 ease-out duration-300" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="delay-150 ease-out duration-300" x-transition:leave-start="opaicty-100 scale-100" x-transition:leave-end="opacity-0 scale-50">
        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </button>

    <!-- Add item button -->
    <button @click="showDropup = !showDropup" @click.away="showDropup = false" class="fixed bottom-4 right-4 md:bottom-12 md:right-12 p-3 bg-blue-800 hover:bg-blue-900 rounded-full transition duration-300 focus:outline-none focus:bg-blue-900 focus:ring ring-blue-400 text-white" :class="{ 'transform rotate-45': showDropup }">
        <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
    </button>

    <!-- Add link modal -->
    <livewire:links.create :board="$board" />
</div>
