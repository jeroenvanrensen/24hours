<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <!-- Metas -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Title -->
    <title>{{ config('app.name') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" />

    <!-- Styles -->
    <livewire:styles />
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

    <!-- Scripts -->
    <livewire:scripts />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.0/dist/alpine.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
</head>
<body x-data="{ showModal: false }" class="dark:bg-gray-800 dark:text-white">
    @if($showNavbar ?? true)
        @if($defaultNavbar ?? true)
            @include('layouts.default-navbar')
        @else
            @include('layouts.custom-navbar', ['backLink' => $backLink])
        @endif

        <div class="max-w-5xl px-6 mx-auto my-6 md:my-12">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif

    <livewire:offline />
</body>
</html>
