@props(['secondary' => false])

<button
    class="px-4 py-2 text-sm font-medium rounded-md focus:outline-none {{
        $secondary
            ? 'text-gray-600 bg-white border border-gray-300 shadow-sm focus:bg-gray-50 hover:bg-gray-50'
            : 'text-white bg-indigo-600 focus:ring-offset-2 focus:ring-2 focus:ring-indigo-500 hover:bg-indigo-700'
    }}"
    {{
    $attributes
    }}
>
    {{ $slot }}
</button>
