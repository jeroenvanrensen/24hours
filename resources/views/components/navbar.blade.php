<nav
    class="flex items-center justify-between w-full px-6 py-6 bg-gray-800 shadow  dark:shadow-lg dark:bg-black md:px-12 lg:px-24"
>
    <a href="{{ route('boards.index') }}" class="w-10 font-medium text-white">24Hours</a>

    <livewire:search />

    <div class="relative w-10" x-data="{ show: false }">
        <!-- Dropdown button -->
        <button
            @click="show = true"
            class="border-2 border-transparent rounded-full  focus:outline-none ring-2 ring-transparent focus:ring-white dark:focus:ring-gray-300"
        >
            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full" />
        </button>

        <!-- Dropdown menu -->
        <div
            x-show="show"
            @click.away="show = false"
            style="display: none"
            class="absolute right-0 z-10 w-48 py-1 mt-2 bg-white rounded-md shadow-lg  dark:bg-black focus:outline-none"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            tabindex="-1"
        >
            <a
                href="{{ route('profile.edit') }}"
                class="block px-4 py-2 text-sm text-gray-700  dark:text-gray-200 dark:hover:bg-gray-800 dark:focus:bg-gray-700 hover:bg-gray-50 focus:bg-gray-100"
            >
                My Profile
            </a>
            <a
                href="javascript:;"
                onclick="document.querySelector('#logout-form').submit()"
                class="block px-4 py-2 text-sm text-gray-700  dark:text-gray-200 hover:bg-gray-50 focus:bg-gray-100 dark:hover:bg-gray-800 dark:focus:bg-gray-700"
            >
                Sign out
            </a>
        </div>

        <!-- Logout form -->
        <form action="{{ route('logout') }}" method="post" id="logout-form">@csrf</form>
    </div>
</nav>
