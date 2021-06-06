<div
    x-data="{ showDropup: false, showModal: false }"
    @keydown.window.escape="if(!showModal) Turbolinks.visit('{{ route('boards.index') }}');"
>
    @if($board->archived)
        <p class="flex items-center justify-center mb-4 space-x-2 text-sm font-bold text-yellow-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span>This board is archived.</span>
        </p>
    @endif

    <x-heading>
        {{ $board->name }}

        <div class="flex items-center ml-4 space-x-2">
            <!-- Edit button -->
            @can('edit', $board)
                <x-boards.action-button title="Edit this board" href="{{ route('boards.edit', $board) }}">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                    </svg>
                </x-boards.action-button>
            @endcan
    
            <!-- Members button -->
            <x-boards.action-button title="View members" href="{{ route('members.index', $board) }}">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                </svg>
            </x-boards.action-button>

            <!-- Archive button -->
            @can('edit', $board)
                <x-boards.action-button :title="$board->archived ? 'Unarchive this board' : 'Archive this board'" button :wire:click="$board->archived ? 'unarchive' : 'archive'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </x-boards.action-button>
            @endcan
        </div>
    </x-heading>

    <!-- Show all items -->
    <livewire:items.index :board="$board" />

    @can('manageItems', $board)
        <!-- Add link dropup -->
        <button x-show="showDropup" @click="showModal = true" class="fixed p-4 text-white transition transform bg-gray-400 rounded-full bottom-36 right-4 md:bottom-48 md:right-12 hover:bg-gray-500 focus:outline-none focus:bg-gray-500 focus:ring ring-gray-400" x-transition:enter="delay-300 ease-out duration-300" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-out duration-300" x-transition:leave-start="opaicty-100 scale-100" x-transition:leave-end="opacity-0 scale-50">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
            </svg>
        </button>

        <!-- Create note dropup -->
        <button x-show="showDropup" wire:click="createNote" class="fixed p-4 text-white transition transform bg-gray-400 rounded-full bottom-20 right-4 md:bottom-32 md:right-12 hover:bg-gray-500 focus:outline-none focus:bg-gray-500 focus:ring ring-gray-400" x-transition:enter="delay-150 ease-out duration-300" x-transition:enter-start="opacity-0 scale-50" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="delay-150 ease-out duration-300" x-transition:leave-start="opaicty-100 scale-100" x-transition:leave-end="opacity-0 scale-50">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>

        <!-- Add item button -->
        <button @click="showDropup = !showDropup" @click.away="showDropup = false" class="fixed p-3 text-white transition duration-300 bg-blue-800 rounded-full bottom-4 right-4 md:bottom-12 md:right-12 hover:bg-blue-900 focus:outline-none focus:bg-blue-900 focus:ring ring-blue-400" :class="{ 'transform rotate-45': showDropup }">
            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
        </button>

        <!-- Add link modal -->
        <livewire:links.create :board="$board" />
    @endcan
</div>
