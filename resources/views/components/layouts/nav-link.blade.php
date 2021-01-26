@props([
    'url' => '#',
    'active' => ($url ?? null) == url()->current()
])

<li class="ml-4">
    <a {{ $attributes->merge([
        'href' => $url,
        'class' => 'focus:outline-none hover:underline focus:underline ' . ($active ? '' : 'text-gray-500')
    ]) }}>
        {{ $slot }}
    </a>
</li>