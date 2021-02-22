@props([
    'url' => '#',
    'active' => ($url ?? null) == url()->current()
])

<li>
    <a href="{{ $url }}" class="flex items-center font-semibold py-1 px-2 md:py-2 md:px-4 rounded-full focus:outline-none {{ $active ? 'md:bg-blue-100 md:dark:bg-gray-700 text-blue-600 focus:bg-blue-200 dark:text-white dark:focus:bg-gray-600' : 'hover:text-blue-600 focus:text-blue-600 dark:hover:text-white dark:focus:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700' }}">
        <div class="hidden md:block mr-2">
            {{ $icon }}
        </div>
        <span>{{ $slot }}</span>
    </a>
</li>