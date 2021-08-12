<div>
    <x-navbar />
    
    <x-container>
        @if($board->archived)
        <p class="flex items-center justify-center mb-4 space-x-2 text-sm font-medium text-yellow-600">
            <x-heroicon-s-exclamation-circle class="w-5 h-5 text-yellow-500" />
            <span>This board is archived. This means it's locked.</span>
        </p>
        @endif
    
        <h1 class="flex justify-between mb-10">
            <span class="text-3xl font-bold">{{ $board->name }}</span>
    
            <div class="flex items-center ml-4 space-x-2">
                <!-- Edit button -->
                @can('edit', $board)
                <x-boards.action-button href="{{ route('boards.edit', $board) }}">
                    <x-heroicon-s-pencil class="w-4 h-4" />
                </x-boards.action-button>
                @endcan
    
                <!-- Members button -->
                <x-boards.action-button href="{{ route('members.index', $board) }}">
                    <x-heroicon-s-user-group class="w-4 h-4" />
                </x-boards.action-button>
    
                <!-- Archive button -->
                @can('edit', $board)
                <x-boards.action-button button :wire:click="$board->archived ? 'unarchive' : 'archive'">
                    <x-heroicon-s-archive class="w-4 h-4" />
                </x-boards.action-button>
                @endcan
            </div>
        </h1>
    
        <!-- Show all items -->
        <livewire:items.index :board="$board" />
    
        @can('manageItems', $board)
        <!-- Add link dropup -->
        <button
            x-show="showDropup"
            @click="showModal = true"
            class="fixed p-4 text-white transition transform bg-gray-400 rounded-full bottom-36 right-4 md:bottom-48 md:right-12 hover:bg-gray-500 focus:outline-none focus:bg-gray-500 focus:ring ring-gray-400"
            x-transition:enter="delay-300 ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-50"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-out duration-300"
            x-transition:leave-start="opaicty-100 scale-100"
            x-transition:leave-end="opacity-0 scale-50"
        >
            <svg
                class="w-6 h-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
                />
            </svg>
        </button>
    
        <!-- Create note dropup -->
        <button
            x-show="showDropup"
            wire:click="createNote"
            class="fixed p-4 text-white transition transform bg-gray-400 rounded-full bottom-20 right-4 md:bottom-32 md:right-12 hover:bg-gray-500 focus:outline-none focus:bg-gray-500 focus:ring ring-gray-400"
            x-transition:enter="delay-150 ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-50"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="delay-150 ease-out duration-300"
            x-transition:leave-start="opaicty-100 scale-100"
            x-transition:leave-end="opacity-0 scale-50"
        >
            <svg
                class="w-6 h-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                />
            </svg>
        </button>
    
        <!-- Add item button -->
        <button
            @click="showDropup = !showDropup"
            @click.away="showDropup = false"
            class="fixed p-3 text-white transition duration-300 bg-blue-800 rounded-full bottom-4 right-4 md:bottom-12 md:right-12 hover:bg-blue-900 focus:outline-none focus:bg-blue-900 focus:ring ring-blue-400"
            :class="{ 'transform rotate-45': showDropup }"
        >
            <svg
                class="w-8 h-8"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                />
            </svg>
        </button>
    
        <!-- Add link modal -->
        <livewire:links.create :board="$board" />
        @endcan
    </x-container>
</div>
