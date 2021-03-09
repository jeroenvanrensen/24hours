@props(['small' => false])

@if($small)

<div class="flex items-center justify-between mb-8">
    <h1 class="font-serif text-2xl md:text-3xl">
        {{ $slot }}
    </h1>

    {{ $right ?? null }}
</div>

@else

<h1 class="flex items-center mb-16 font-serif text-3xl md:mb-24 md:text-4xl md:text-center md:justify-center group">
    {{ $slot }}
</h1>

@endif
