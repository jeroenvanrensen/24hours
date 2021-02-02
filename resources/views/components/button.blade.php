@props([
    'color' => 'blue',
    'link' => false,
    'secondary' => false,
    'loading' => null
])

@if($secondary)

<{{ $link ? 'a' : 'button' }} {{ $attributes->merge([
    'class' => 'py-2 px-6 bg-gray-100 rounded transition hover:bg-gray-200 focus:bg-gray-200 focus:outline-none focus:ring-2 ring-blue-400',
    'wire:loading.class' => 'opacity-50 pointer-events-none',
    'wire:target' => $loading
]) }}>
    <svg wire:loading wire:target="{{ $loading }}" class="animate-spin -mt-1 mr-2 -ml-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>

    {{ $slot }}
</{{ $link ? 'a' : 'button' }}>

@else

<{{ $link ? 'a' : 'button' }} {{ $attributes->merge([
    'class' => 'py-2 px-6 bg-' . $color . '-800 rounded text-white transition hover:bg-' . $color . '-900 focus:bg-' . $color . '-900 focus:outline-none focus:ring-2 ring-blue-400',
    'wire:loading.class' => 'opacity-50 pointer-events-none',
    'wire:target' => $loading
]) }}>
    <svg wire:loading wire:target="{{ $loading }}" class="animate-spin -mt-1 mr-2 -ml-1 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
    </svg>

    {{ $slot }}
</{{ $link ? 'a' : 'button' }}>

@endif
