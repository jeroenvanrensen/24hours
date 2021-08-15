<div x-data @keydown.escape.window="!$store.modalOpen && Turbolinks.visit('{{ route('boards.index') }}')">
    <x-navbar />
    
    <x-container>    
        <h1 class="flex justify-between mb-10">
            <div class="flex items-center w-full space-x-4">
                <span class="text-3xl font-bold">{{ $board->name }}</span>
                @if($board->archived)
                <div class="relative flex items-center w-full" x-data="{ show: false }">
                    <span
                        @mouseenter="show = true"
                        @mouseleave="show = false"
                        class="px-2 py-1 text-sm font-medium text-indigo-800 uppercase bg-indigo-100 rounded-md"
                    >
                        Archived
                    </span>

                    <div
                        x-show="show"
                        class="absolute px-1 py-px ml-24 text-xs font-medium text-indigo-800 uppercase bg-indigo-100 rounded"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    >
                        This board is archived. This means it's locked.
                    </div>
                </div>
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
        <div class="fixed flex-col w-60 bottom-12 right-12" x-data="{ showDropup: false }">
            <!-- Add link dropup -->
            <div class="relative flex items-center justify-end w-full mb-2" x-data="{ show: false }">
                <div
                    x-show="show"
                    class="absolute px-2 py-1 text-sm font-medium text-center text-white bg-gray-800 rounded-md shadow-xl right-18"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100 delay-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                >
                    Add a link
                </div>

                <button
                    @mouseenter="show = true"
                    @mouseleave="show = false"
                    x-show="showDropup"
                    @click="$dispatch('create-link')"
                    class="flex items-center justify-center text-white transition transform bg-gray-400 rounded-full shadow-lg h-14 w-14 hover:bg-gray-500 focus:bg-gray-500 focus:ring ring-gray-400"
                    x-transition:enter="delay-300 ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-50"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="ease-out duration-300"
                    x-transition:leave-start="opaicty-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-50"
                >
                    <x-heroicon-o-link class="w-6 h-6" />
                </button>
            </div>
        
            <!-- Create note dropup -->
            <div class="relative flex items-center justify-end w-full mb-4" x-data="{ show: false }">
                <div
                    x-show="show"
                    class="absolute px-2 py-1 text-sm font-medium text-center text-white bg-gray-800 rounded-md shadow-xl right-18"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100 delay-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                >
                    Create a new note
                </div>
            
                <button
                    @mouseenter="show = true"
                    @mouseleave="show = false"
                    x-show="showDropup"
                    wire:click="createNote"
                    class="flex items-center justify-center text-white transition transform bg-gray-400 rounded-full shadow-lg h-14 w-14 hover:bg-gray-500 focus:bg-gray-500 focus:ring ring-gray-400"
                    x-transition:enter="delay-150 ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-50"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="delay-150 ease-out duration-300"
                    x-transition:leave-start="opaicty-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-50"
                >
                    <x-heroicon-o-pencil-alt class="w-6 h-6" />
                </button>
            </div>
        
            <!-- Add item button -->
            <div class="relative flex items-center justify-end w-full" x-data="{ show: false }">
                <div
                    x-show="show"
                    class="absolute px-2 py-1 text-sm font-medium text-center text-white bg-gray-800 rounded-md shadow-xl right-18"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-100 delay-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                >
                    New item
                </div>

                <button
                    @mouseenter="show = true"
                    @mouseleave="show = false"
                    @click="showDropup = !showDropup"
                    @click.away="showDropup = false"
                    class="flex items-center justify-center text-white transition duration-300 bg-indigo-600 rounded-full shadow-lg w-14 h-14 hover:bg-indigo-700 focus:bg-indigo-700 focus:ring focus:ring-indigo-300"
                    :class="{ 'transform rotate-45': showDropup }"
                >
                    <x-heroicon-o-plus class="w-8 h-8" />
                </button>
            </div>
        </div>
    
        <!-- Add link modal -->
        <livewire:links.create :board="$board" />
        @endcan
    </x-container>
</div>
