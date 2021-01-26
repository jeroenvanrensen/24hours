<div>
    <p class="mb-3 text-center text-gray-600">{{ today()->format('l, F d') }}</p>
    <x-heading>Welcome back, {{ auth()->user()->name }}</x-heading>

    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-3xl font-serif">My Boards</h2>
        <a href="{{ route('boards.create') }}" class="flex items-center py-2 px-4 border border-blue-800 hover:bg-blue-800 hover:text-white focus:outline-none rounded-full text-blue-800 font-semibold focus:bg-blue-800 focus:text-white">
            <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            <span>New Board</span>
        </a>
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
</div>
