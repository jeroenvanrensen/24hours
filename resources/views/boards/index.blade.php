<div x-data="{ showModal: false }">
    <p class="mb-3 text-center text-gray-600">{{ today()->format('l, F d') }}</p>
    <x-heading>Welcome back, {{ auth()->user()->name }}</x-heading>

    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-3xl font-serif">My Boards</h2>
        <x-button @click="showModal = true">New Board</x-button>
    </div>

    <ul class="grid grid-cols-3 gap-6">
        @foreach($boards as $board)
            <li>
                <a href="{{ route('boards.show', $board) }}" class="group focus:outline-none">
                    <div class="mb-2 h-32 bg-gray-200 group-hover:bg-gray-300 group-focus:bg-gray-300 rounded-lg">&nbsp;</div>
                    <span class="font-semibold text-lg">{{ $board->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    <livewire:boards.create />
</div>
