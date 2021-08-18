<div>
    <x-navbar />
    <x-container>
        <div x-data class="flex items-center justify-between mb-10">
            <h1 class="text-3xl font-bold ">My Boards</h1>
            <x-button @click="$dispatch('create-board')">New Board</x-button>
        </div>
        
        @if(count($boards) == 0 && count($archivedBoards) == 0)
        <p x-data>You don't have any boards yet. <x-link href="javascript:;" @click="$dispatch('create-board')">Create one.</x-link></p>
        @endif
    
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
            @foreach($boards as $board)
                <x-card
                    :link="route('boards.show', $board)"
                    :image="asset($board->image)"
                    :altText="$board->name . ' cover image'"
                    :title="$board->name"
                    :description="$board->updated_at->format('F j, Y')"
                />
            @endforeach
        </div>

        @if(count($archivedBoards) > 0)
        @if(count($boards) > 0)
        <h1 class="mt-16 mb-10 text-3xl font-bold">Archived Boards</h1>
        @endif
    
        <div class="grid grid-cols-4 gap-8">
            @foreach($archivedBoards as $board)
                <x-card
                    :link="route('boards.show', $board)"
                    :image="asset($board->image)"
                    :altText="$board->name . 'cover image'"
                    :title="$board->name"
                    :description="$board->updated_at->format('F j, Y')"
                />
            @endforeach
        </div>
        @endif
    </x-container>

    <x-modal name="create-board" title="New Board">
        <livewire:boards.create />
    </x-modal>
</div>
