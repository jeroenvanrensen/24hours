<nav class="py-4 px-6 md:px-12 flex items-center justify-between">
    <a href="{{ auth()->check() ? route('boards.index') : route('home') }}" class="font-serif focus:underline focus:outline-none tracking-wide text-xl md:w-0">24Hours</a>

    <ul class="flex">
        @auth
            <x-layouts.nav-link url="{{ route('boards.index') }}">
                <x-slot name="icon"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg></x-slot>
                <span class="hidden md:inline">Home</span>
            </x-layouts.nav-link>
            
            <x-layouts.nav-link url="{{ route('search') }}">
                <x-slot name="icon"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></x-slot>
                <span class="hidden md:inline">Search</span>
            </x-layouts.nav-link>
        @else
            <x-layouts.nav-link url="{{ route('login') }}">
                <x-slot name="icon"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg></x-slot>
                Login
            </x-layouts.nav-link>
            
            <x-layouts.nav-link url="{{ route('register') }}">
                <x-slot name="icon"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg></x-slot>
                Register
            </x-layouts.nav-link>
        @endauth
    </ul>

    @auth
        <a href="{{ route('profile.edit') }}" class="p-2 rounded-full bg-gray-100 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 text-gray-600 md:w-0">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </a>
    @endauth
</nav>
