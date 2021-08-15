<x-search-result :link="route('links.show', $result)" :text="$result->title" target="_blank" :loop="$loop->iteration">
    <x-slot name="icon">
        <x-heroicon-o-link />
    </x-slot>
</x-search-result>
