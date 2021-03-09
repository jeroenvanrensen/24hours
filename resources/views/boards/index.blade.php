<div x-data="{ showModal: false }">
    <p class="mb-3 text-gray-600 md:text-center dark:text-gray-300">{{ today()->format('l, F j') }} (Week {{ (int) today()->format('W') }})</p>
    <x-heading>Welcome back, {{ auth()->user()->first_name }}</x-heading>

    <div class="flex items-center justify-between mb-8">
        <h2 class="font-serif text-2xl md:text-3xl">My Boards</h2>
        <x-button @click="showModal = true">New Board</x-button>
    </div>

    <ul class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @foreach($boards as $board)
            <li>
                <a href="{{ route('boards.show', $board) }}" class="group focus:outline-none">
                    <div class="flex items-center justify-center mb-2 bg-gray-200 rounded-lg h-36 lg:h-40 group-hover:bg-gray-300 group-focus:bg-gray-300 dark:bg-gray-700 dark:group-hover:bg-gray-600 dark:group-focus:bg-gray-600">
                    <svg class="w-12 h-12 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
</svg>
                    </div>

                    <span class="text-lg font-semibold">{{ $board->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    @if(count($boards) == 0)
        <p>No Boards Found.</p>
    @endif

    <livewire:boards.create />
</div>
