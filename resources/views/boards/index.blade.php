<div>
    <p class="mb-3 text-center text-gray-600">{{ today()->format('l, F d') }}</p>
    <h1 class="mb-24 text-4xl text-center font-serif">Welcome back, {{ auth()->user()->name }}</h1>

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
                <div class="mb-2 h-32 bg-gray-200 rounded-lg">&nbsp;</div>
                <span class="font-semibold text-lg">{{ $board->name }}</span>
            </li>
        @endforeach
    </ul>
</div>
