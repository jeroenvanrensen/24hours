@if(is_numeric($loop))
<a
    href="{{ $link }}"
    class="flex items-center w-full px-4 py-2 space-x-3  dark:hover:bg-gray-800 dark:focus:bg-gray-700 hover:bg-gray-50 focus:bg-gray-200 focus:outline-none"
    {{
    $attributes
    }}
    @keydown.up.prevent="{{ $loop == 1 ? '$refs.input.focus()' : '$refs.search' . ($loop - 1) . '.focus()' }}"
    @keydown.down.prevent="$refs.search{{ $loop + 1 }}.focus()"
    x-ref="search{{ $loop }}"
>
    <div class="w-5 h-5 text-gray-700 dark:text-gray-300">
        {{ $icon }}
    </div>

    <span class="dark:text-gray-200">{{ $text }}</span>
</a>
@endif
