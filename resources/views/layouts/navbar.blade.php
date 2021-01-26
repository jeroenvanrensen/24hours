<div class="bg-white w-full shadow py-4">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <div class="flex items-center">
            <!-- Brand -->
            <a href="{{ url('/') }}" class="text-lg font-semibold focus:outline-none focus:underline">{{ config('app.name') }}</a>

            <!-- Left side navbar -->
            <ul class="ml-6 flex items-center">
                @auth
                    <x-layouts.nav-link url="{{ route('dashboard') }}">Dashboard</x-layouts.nav-link>
                @endauth
            </ul>
        </div>
        
        <div class="flex items-center">
            <!-- Right side navbar -->
            <ul class="flex items-center">
                @auth
                    <x-layouts.nav-link url="{{ route('account.edit') }}">My Account</x-layouts.nav-link>
                    <x-layouts.nav-link wire:click="logout">Logout</x-layouts.nav-link>
                @else
                    <x-layouts.nav-link url="{{ route('login') }}">Login</x-layouts.nav-link>
                    <x-button class="ml-4" link size="small" href="{{ route('register') }}">Register</x-button>
                @endauth
            </ul>
        </div>
    </div>
</div>
