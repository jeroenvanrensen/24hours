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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;0,700;1,500&family=Source+Code+Pro&display=swap" /> 
    </head>
    <body x-data @turbolinks.window="$store.modalOpen = false" class="dark:bg-gray-800 dark:text-white">
        {{ $slot }}

        <x-flash />

        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('modalOpen', false);
                
                // Fix a bug where the $store.modalOpen state keeps being true
                // after a new page visit, and then the escape key won't work
                document.addEventListener('turbolinks:visit', () => {
                    let event = new CustomEvent('turbolinks');
                    window.dispatchEvent(event);
                });
            });
        </script>
    </body>
</html>
