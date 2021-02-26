<nav class="py-8 px-6 md:px-12 flex items-center justify-between">
    <div class="flex items-center">
        <a href="{{ $backLink }}" class="block mr-2 md:mr-5 p-2 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 dark:bg-gray-600 dark:focus:bg-gray-500 dark:hover:bg-gray-500">
            <svg class="w-5 h-5 text-gray-600 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>

        <span class="font-semibold">{{ $backText }}</span>
    </div>

    {!! $right ?? null !!}
</nav>