<a
    href="{{ $link }}"
    class="flex items-center w-full px-4 py-2 space-x-3  hover:bg-gray-50 focus:bg-gray-200 focus:outline-none"
    {{
    $attributes
    }}
    @keydown.up="{{ $loop == 1 ? '$refs.input.focus()' : '$refs.search' . $loop - 1 . '.focus()' }}"
    @keydown.down="$refs.search{{ $loop + 1 }}.focus()"
    x-ref="search{{ $loop }}"
>
    <div class="w-5 h-5 text-gray-700">
        {{ $icon }}
    </div>

    <span>{{ $text }}</span>
</a>
