@props(['newTab' => false, 'archived', 'loop', 'color', 'icon', 'url'])

@php

$iconColor = [
    'yellow' => 'bg-yellow-100 dark:bg-yellow-600 text-yellow-500 dark:text-yellow-300',
    'blue' => 'bg-blue-100 dark:bg-blue-600 text-blue-400 dark:text-blue-300',
    'green' => 'bg-green-100 dark:bg-green-600 text-green-500 dark:text-green-300',
][$color];

$archivedColor = [
    'yellow' => 'text-yellow-800 bg-yellow-100',
    'blue' => 'text-blue-800 bg-blue-100',
    'green' => 'text-green-800 bg-green-100'
][$color];

@endphp

<a href="{{ $url }}" class="flex items-center py-4 focus:outline-none focus:underline {{ $loop->first ? '' : 'border-t border-gray-200 dark:border-gray-700' }}" {{ $newTab ? 'target="_blank"' : '' }}>
    <div class="p-2 mr-3 rounded-lg {{ $iconColor }}">
        {{ $icon }}
    </div>

    <div class="mr-2 font-semibold">{{ $text }}</div>

    @if($archived)
        <span class="px-2 py-1 text-xs font-semibold uppercase rounded {{ $archivedColor }}">Archived</span>
    @endif
</a>
