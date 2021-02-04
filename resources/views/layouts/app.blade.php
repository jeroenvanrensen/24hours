<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <!-- Metas -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Title -->
    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <livewire:styles />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" />

    <!-- Scripts -->
    <livewire:scripts />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
</head>
<body x-data="{ showModal: false }">
    @if($showNavbar ?? true)
        @include('layouts.navbar')

        <div class="max-w-5xl mx-auto px-6 my-8 md:my-12">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif
</body>
</html>
