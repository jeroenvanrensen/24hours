<nav class="py-4 px-12 flex items-center justify-between">
    <a href="{{ route('boards.index') }}" class="font-serif focus:underline focus:outline-none tracking-wide text-xl w-0">24Hours</a>

    <ul class="flex">
        <li>
            <a href="{{ route('boards.index') }}" class="flex items-center font-semibold py-2 px-4 rounded-full focus:outline-none {{ url()->current() == route('boards.index') ? 'bg-blue-100 text-blue-600 focus:bg-blue-200' : 'hover:text-blue-600 focus:text-blue-600' }}">
                <svg class="mr-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Home</span>
            </a>
        </li>
    </ul>

    &nbsp;
</nav>
