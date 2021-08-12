<div>
    <x-navbar />
    
    <x-container>    
        <h1 class="flex justify-between mb-10">
            <div class="flex items-center space-x-4">
                <span class="text-3xl font-bold">{{ $board->name }}</span>
                @if($board->archived)
                <span class="px-2 py-1 text-xs font-medium text-indigo-800 uppercase bg-indigo-100 rounded-md">Archived</span>
                @endif
            </div>
    
            <div class="flex items-center ml-4 space-x-3">
                <!-- Edit button -->
                @can('edit', $board)
                <x-button secondary link href="{{ route('boards.edit', $board) }}">
                    <div class="flex items-center space-x-1">
                        <x-heroicon-s-pencil class="w-4 h-4" />
                        <span>Edit</span>
                    </div>
                </x-button>
                @endcan
    
                <!-- Members button -->
                <x-button secondary link href="{{ route('members.index', $board) }}">
                    <div class="flex items-center space-x-2">
                        <x-heroicon-s-user-group class="w-4 h-4" />
                        <span>Members</span>
                    </div>
                </x-button>
    
                <!-- Archive button -->
                @can('edit', $board)
                <x-button secondary :wire:click="$board->archived ? 'unarchive' : 'archive'">
                    <div class="flex items-center space-x-1">
                        <x-heroicon-s-archive class="w-4 h-4" />
                        <span>{{ $board->archived ? 'Unarchive' : 'Archive' }}</span>
                    </div>
                </x-button>
                @endcan
            </div>
        </h1>
    
        <!-- Show all items -->
        <livewire:items.index :board="$board" />
    
        @can('manageItems', $board)
        <div class="fixed flex-col bottom-12 right-12" x-data="{ showDropup: false }">
            <!-- Add link dropup -->
            <button
                x-show="showDropup"
                @click="$dispatch('create-link')"
                class="flex items-center justify-center mb-2 text-white transition transform bg-gray-400 rounded-full shadow-lg h-14 w-14 hover:bg-gray-500 focus:bg-gray-500 focus:ring ring-gray-400"
                x-transition:enter="delay-300 ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-50"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-out duration-300"
                x-transition:leave-start="opaicty-100 scale-100"
                x-transition:leave-end="opacity-0 scale-50"
            >
                <x-heroicon-o-link class="w-6 h-6" />
            </button>
        
            <!-- Create note dropup -->
            <button
                x-show="showDropup"
                wire:click="createNote"
                class="flex items-center justify-center mb-4 text-white transition transform bg-gray-400 rounded-full shadow-lg h-14 w-14 hover:bg-gray-500 focus:bg-gray-500 focus:ring ring-gray-400"
                x-transition:enter="delay-150 ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-50"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="delay-150 ease-out duration-300"
                x-transition:leave-start="opaicty-100 scale-100"
                x-transition:leave-end="opacity-0 scale-50"
            >
                <x-heroicon-o-pencil-alt class="w-6 h-6" />
            </button>
        
            <!-- Add item button -->
            <button
                @click="showDropup = !showDropup"
                @click.away="showDropup = false"
                class="flex items-center justify-center text-white transition duration-300 bg-indigo-600 rounded-full shadow-lg w-14 h-14 hover:bg-indigo-700 focus:bg-indigo-700 focus:ring focus:ring-indigo-300"
                :class="{ 'transform rotate-45': showDropup }"
            >
                <x-heroicon-o-plus class="w-8 h-8" />
            </button>
        </div>
    
        <!-- Add link modal -->
        <livewire:links.create :board="$board" />
        @endcan
    </x-container>
</div>
