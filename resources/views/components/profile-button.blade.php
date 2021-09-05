<li class="mb-1">
    <a
        href="{{ $url }}"
        class="flex items-center px-6 py-3 space-x-3 font-medium text-gray-800 dark:text-gray-200 rounded-md {{ url()->current() === $url ? 'bg-gray-100 focus:bg-gray-200 dark:bg-gray-700 dark:focus:bg-gray-600' : 'focus:bg-gray-100 dark:focus:bg-gray-700' }}"
    >
        <x-dynamic-component component="heroicon-o-{{ $icon }}" class="w-6 h-6 text-gray-700 dark:text-gray-300" />
        <span>{{ $text }}</span>
    </a>
</li>
