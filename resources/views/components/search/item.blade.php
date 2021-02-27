@props(['newTab' => false, 'loop' => null])

<a href="{{ $url }}" class="flex items-center py-4 {{ $loop->first ? '' : 'border-t border-gray-200 dark:border-gray-700' }} focus:outline-none focus:underline" {{ $newTab ? 'target="_blank"' : '' }}>
    <div class="mr-3 p-2 bg-{{ $color }}-100 dark:bg-{{ $color }}-600 rounded-lg">
        <div class="text-{{ $color }}-400 dark:text-{{ $color }}-300">
            {{ $icon }}
        </div>
    </div>

    <span class="font-semibold">{{ $text }}</span>
</a>
