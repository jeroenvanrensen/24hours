<x-search.item :loop="$loop">
    <x-slot name="url">{{ route('notes.edit', $result) }}</x-slot>
    <x-slot name="color">blue</x-slot>
    <x-slot name="icon"><svg class="w-6 h-6 text-blue-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></x-slot>
    <x-slot name="text">{{ $result->title }}</x-slot>
</x-search.item>
