<nav class="py-4 px-12 flex items-center justify-between">
    <a href="{{ route('boards.index') }}" class="font-serif focus:underline focus:outline-none tracking-wide text-xl w-0">24Hours</a>

    <ul class="flex">
        <x-layouts.nav-link url="{{ route('boards.index') }}">
            <x-slot name="icon"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg></x-slot>
            Home
        </x-layouts.nav-link>
        
        <x-layouts.nav-link url="{{ route('search') }}">
            <x-slot name="icon"><svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></x-slot>
            Search
        </x-layouts.nav-link>
    </ul>

    <a href="{{ route('profile.edit') }}" class="p-2 rounded-full bg-gray-100 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 text-gray-600">
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
    </a>
</nav>
