<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <!-- Metas -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Title -->
        <title>{{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
        <livewire:styles />

        <!-- Scripts -->
        <livewire:scripts />
        <script src="https://unpkg.com/alpinejs@3.2.3/dist/cdn.min.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/turbolinks/5.2.0/turbolinks.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js"></script>

        <!-- Fonts -->
        <link
            href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"
            rel="stylesheet"
        />
    </head>
    <body>
        {{ $slot }}

        <x-flash />

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('modalOpen', false);
            });
        </script>
    </body>
</html>
