<x-search-result :link="route('links.show', $result)" :text="$result->title" target="_blank">
    <x-slot name="icon">
        <x-heroicon-o-link />
    </x-slot>
</x-search-result>
