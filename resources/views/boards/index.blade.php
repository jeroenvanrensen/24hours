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
    
        <div class="grid grid-cols-4 gap-8">
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
                    :image="[
                        'https://images.unsplash.com/photo-1448375240586-882707db888b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                        'https://images.unsplash.com/photo-1461360370896-922624d12aa1?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1353&q=80',
                        'https://images.unsplash.com/photo-1458560871784-56d23406c091?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=967&q=80',
                        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                        'https://images.unsplash.com/photo-1509869175650-a1d97972541a?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80',
                        'https://images.unsplash.com/photo-1476966502122-c26b7830def9?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1372&q=80'
                    ][rand(0, 4)]"
                    :altText="$board->name . 'cover image'"
                    :title="$board->name"
                    :description="$board->updated_at->format('F j, Y')"
                />
            @endforeach
        </div>
        @endif
    </x-container>

    <livewire:boards.create />
</div>
