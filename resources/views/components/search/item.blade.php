@props(['newTab' => false, 'loop' => null])

@php

// All possible colors are here for purging css classes
$colors = [
    'yellow' => ['bg-yellow-100', 'dark:bg-yellow-600', 'text-yellow-400', 'dark:text-yellow-300'],
    'blue' => ['bg-blue-100', 'dark:bg-blue-600', 'text-blue-400', 'dark:text-blue-300'],
    'green' => ['bg-green-100', 'dark:bg-green-600', 'text-green-400', 'dark:text-green-300'],
];

@endphp

<a href="{{ $url }}" class="flex items-center py-4 {{ $loop->first ? '' : 'border-t border-gray-200 dark:border-gray-700' }} focus:outline-none focus:underline" {{ $newTab ? 'target="_blank"' : '' }}>
    <div class="mr-3 p-2 bg-{{ $color }}-100 dark:bg-{{ $color }}-600 rounded-lg">
        <div class="text-{{ $color }}-400 dark:text-{{ $color }}-300">
            {{ $icon }}
        </div>
    </div>

    <span class="font-semibold">{{ $text }}</span>
</a>
