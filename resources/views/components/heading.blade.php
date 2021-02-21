@props(['small' => false])

@if($small)

<h1 class="mb-8 text-2xl md:text-3xl font-serif">
    {{ $slot }}
</h1>

@else

<h1 class="mb-16 md:mb-24 text-3xl md:text-4xl md:text-center font-serif flex items-center md:justify-center group">
    {{ $slot }}
</h1>

@endif
