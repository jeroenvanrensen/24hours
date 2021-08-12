<a
    href="{{ $link }}"
    class="flex items-center w-full px-4 py-2 space-x-3 hover:bg-gray-50"
    {{
    $attributes
    }}
>
    <div class="w-5 h-5 text-gray-700">
        {{ $icon }}
    </div>

    <span>{{ $text }}</span>
</a>
