@props(['color' => 'blue', 'text'])

@php

$bgColor = [
    'blue' => 'text-blue-800 bg-blue-100 dark:bg-blue-900 dark:text-gray-200',
    'green' => 'text-green-800 bg-green-100 dark:bg-green-900 dark:text-gray-200'
][$color];

$iconColor = [
    'blue' => 'text-blue-600 dark:text-blue-400',
    'green' => 'text-green-600 dark:text-green-400'
][$color];

@endphp

<div {{ $attributes }} class="flex items-center px-4 py-3 mb-6 space-x-2 text-sm font-medium rounded-md {{ $bgColor }}">
    <div class="w-5 h-5 {{ $iconColor }}">{{ $icon }}</div>
    <span>{{ $text }}</span>
</div>
