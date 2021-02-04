<div x-data="{ showModal: false }">
    <p class="mb-3 md:text-center text-gray-600">{{ today()->format('l, F j') }} (Week {{ str_replace('0', '', today()->format('W')) }})</p>
    <x-heading>Welcome back, {{ auth()->user()->first_name }}</x-heading>

    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-2xl md:text-3xl font-serif">My Boards</h2>
        <x-button @click="showModal = true">New Board</x-button>
    </div>

    <ul class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($boards as $board)
            <li>
                <a href="{{ route('boards.show', $board) }}" class="group focus:outline-none">
                    <div class="mb-2 h-32 bg-gray-200 group-hover:bg-gray-300 group-focus:bg-gray-300 rounded-lg flex items-center justify-center">
                    <svg class="w-12 h-12 text-yellow-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
</svg>
                    </div>

                    <span class="font-semibold text-lg">{{ $board->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>

    @if(count($boards) == 0)
        <p>No Boards Found.</p>
    @endif

    <livewire:boards.create />
</div>
