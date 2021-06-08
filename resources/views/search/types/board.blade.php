<x-search.item
    :loop="$loop"
    :archived="$result->archived"
    color="yellow"
    :url="route('boards.show', $result)"
>
    <x-slot name="icon"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg></x-slot>
    <x-slot name="text">{{ $result->name }}</x-slot>
</x-search.item>
