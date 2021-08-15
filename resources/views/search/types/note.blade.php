<x-search-result :link="route('notes.edit', $result)" :text="$result->title" :loop="$loop->iteration">
    <x-slot name="icon">
        <x-heroicon-o-pencil-alt />
    </x-slot>
</x-search-result>
