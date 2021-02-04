<div class="bg-gray-200 dark:bg-gray-900 w-full min-h-screen">
    @include('layouts.navbar')

    <!-- Hero -->
    <div class="mt-8 md:mt-32 max-w-6xl mx-auto px-6">
        <div class="text-center">
            <h1 class="text-3xl md:text-5xl font-bold">Lorem ipsum dolor sit amet.</h1>
            <p class="mt-4 mb-8 md:mt-8 md:mb-10 text-gray-700 dark:text-gray-400 text-lg max-w-4xl mx-auto">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Ut, esse. Odio voluptas, labore repellat accusantium totam perspiciatis quis voluptate, praesentium ducimus et quisquam. Alias molestiae harum, nisi quam sit laborum.</p>
            <x-button link href="{{ route('register') }}" class="py-3">Sign up for free</x-button>
        </div>
        
        <img src="{{ asset('img/screenshot.png') }}" class="mt-20 md:mt-32 rounded md:rounded-xl shadow-sm mx-auto">
    </div>

    <!-- Dark background -->
    <div class="-mt-28 md:-mt-72 pt-32 md:pt-96 bg-gray-800">&nbsp;</div>

    <!-- Features -->
    <div class="py-12 md:py-24 max-w-5xl mx-auto px-6">
        <div class="mb-8 md:mb-16 md:text-center">
            <h2 class="text-blue-800 dark:text-blue-400 font-semibold uppercase tracking-wide">Lorem, ipsum</h2>
            <p class="mt-2 mb-4 md:mt-4 text-3xl leading-8 font-bold tracking-tight text-gray-900 dark:text-white">Lorem ipsum dolor sit amet consectetur.</p>
        </div>

        <div class="md:grid grid-cols-2 gap-8 lg:gap-6">
            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></x-slot>
                <x-slot name="title">Lorem, ipsum dolor.</x-slot>
                <x-slot name="description">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Provident id minus, officiis reiciendis vitae eligendi.</x-slot>
            </x-home.feature>

            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></x-slot>
                <x-slot name="title">Lorem ipsum dolor sit amet.</x-slot>
                <x-slot name="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis amet blanditiis, itaque accusantium dolore facere odit cumque, inventore maiores repudiandae quos. Iste praesentium aperiam fugiat.</x-slot>
            </x-home.feature>

            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></x-slot>
                <x-slot name="title">Lorem ipsum dolor sit.</x-slot>
                <x-slot name="description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloribus cumque fugit minima explicabo eius necessitatibus autem nemo tempora quis beatae?</x-slot>
            </x-home.feature>

            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></x-slot>
                <x-slot name="title">Lorem, ipsum dolor.</x-slot>
                <x-slot name="description">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Provident id minus, officiis reiciendis vitae eligendi.</x-slot>
            </x-home.feature>

            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></x-slot>
                <x-slot name="title">Lorem ipsum dolor sit amet.</x-slot>
                <x-slot name="description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis amet blanditiis, itaque accusantium dolore facere odit cumque, inventore maiores repudiandae quos. Iste praesentium aperiam fugiat.</x-slot>
            </x-home.feature>

            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"><svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg></x-slot>
                <x-slot name="title">Lorem ipsum dolor sit.</x-slot>
                <x-slot name="description">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Doloribus cumque fugit minima explicabo eius necessitatibus autem nemo tempora quis beatae?</x-slot>
            </x-home.feature>
        </div>
    </div>

    <!-- Stats -->
    <div class="py-20 md:py-24 bg-gray-800">
        <div class="max-w-2xl mx-auto px-6">
            <h2 class="mb-12 font-bold text-white text-3xl text-center">24Hours in numbers</h2>

            <div class="grid grid-cols-4">
                <x-home.stat>
                    <x-slot name="title">{{ App\Models\User::count() }}</x-slot>
                    <x-slot name="description">Users</x-slot>
                </x-home.stat>

                <x-home.stat>
                    <x-slot name="title">{{ App\Models\Board::count() }}</x-slot>
                    <x-slot name="description">Boards</x-slot>
                </x-home.stat>
                
                <x-home.stat>
                    <x-slot name="title">{{ App\Models\Link::count() }}</x-slot>
                    <x-slot name="description">Links</x-slot>
                </x-home.stat>
                
                <x-home.stat>
                    <x-slot name="title">{{ App\Models\Note::count() }}</x-slot>
                    <x-slot name="description">Notes</x-slot>
                </x-home.stat>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="py-16 md:py-24 text-center">
        <x-button link href="{{ route('register') }}" class="py-3">Sign up for free</x-button>
    </div>

    <!-- Footer -->
    <div class="py-8 md:py-6 lg:py-8 bg-gray-300 dark:bg-gray-800">
        <div class="max-w-6xl mx-auto px-6">
            &copy; Copyright {{ date('Y') }} by <a href="https://www.jeroenvanrensen.nl/" class="underline focus:text-gray-500 focus:outline-none" target="_blank">Jeroen van Rensen</a>
        </div>
    </div>
</div>
