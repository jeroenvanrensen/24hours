@props([
    'url' => '#',
    'active' => ($url ?? null) == url()->current()
])

<li>
    <a href="{{ $url }}" class="flex items-center font-semibold py-1 px-2 md:py-2 md:px-4 rounded-full focus:outline-none {{ $active ? 'md:bg-blue-100 text-blue-600 focus:bg-blue-200' : 'hover:text-blue-600 focus:text-blue-600' }}">
        <div class="mr-2">
            {{ $icon }}
        </div>
        <span>{{ $slot }}</span>
    </a>
</li>