@props(['secondary' => false, 'link' => false])

<{{ $link ? 'a' : 'button' }}
    class="px-4 py-2 text-sm font-medium rounded-md focus:outline-none {{
        $secondary
            ? 'text-gray-600 bg-white border border-gray-300 shadow-sm focus:bg-gray-50 hover:bg-gray-50 dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white dark:border-transparent dark:focus:bg-gray-500'
            : 'text-white bg-indigo-600 focus:ring-offset-2 focus:ring-2 focus:ring-indigo-500 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:ring-offset-gray-800 dark:focus:ring-indigo-400'
    }}"
    {{
    $attributes
    }}
>
    {{ $slot }}
</{{ $link ? 'a' : 'button' }}>
