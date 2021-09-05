<li>
    <a
        href="{{ $url }}"
        class="flex items-center px-2 -mx-2 md:px-4 py-2 md:py-3 space-x-2 md:space-x-3 font-medium text-gray-800 dark:text-gray-200 rounded-md {{ url()->current() === $url ? 'bg-gray-100 focus:bg-gray-200 dark:bg-gray-700 dark:focus:bg-gray-600' : 'focus:bg-gray-100 dark:focus:bg-gray-700' }}"
    >
        <x-dynamic-component component="heroicon-o-{{ $icon }}" class="w-5 h-5 text-gray-700 md:w-6 md:h-6 dark:text-gray-300" />
        <span>{{ $text }}</span>
    </a>
</li>
