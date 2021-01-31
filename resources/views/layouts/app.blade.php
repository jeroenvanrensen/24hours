<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>{{ config('app.name') }}</title>

    <livewire:styles />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    @stack('styles')

    <livewire:scripts />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false"></script>
    @stack('scripts')
</head>
<body>
    @if($showNavbar ?? true)
        @include('layouts.navbar')
    @else
        {{ $navbar }}
    @endif

    <div class="max-w-5xl mx-auto px-4 my-8 md:my-12">
        {{ $slot }}
    </div>
</body>
</html>
