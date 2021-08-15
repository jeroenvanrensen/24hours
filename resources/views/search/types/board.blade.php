<x-search-result :link="route('boards.show', $result)" :text="$result->name" :loop="$loop->iteration">
    <x-slot name="icon">
        <x-heroicon-o-duplicate />
    </x-slot>
</x-search-result>
