<x-search-result :link="route('boards.show', $result)" :text="$result->name">
    <x-slot name="icon">
        <x-heroicon-o-duplicate />
    </x-slot>
</x-search-result>
