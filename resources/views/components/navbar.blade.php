<nav class="flex items-center justify-between w-full px-24 py-6 bg-gray-800 shadow">
    <a href="{{ route('boards.index') }}" class="w-10 font-medium text-white">24Hours</a>

    <div class="relative w-full max-w-md">
        <div class="absolute flex items-center h-10 pointer-events-none left-8">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="w-5 h-5 text-gray-300"
                viewBox="0 0 20 20"
                fill="currentColor"
            >
                <path
                    fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"
                />
            </svg>
        </div>

        <input
            type="text"
            class="w-full px-4 py-2 ml-4 text-gray-200 placeholder-gray-300 transition duration-200 bg-gray-600 rounded-md  pl-11 focus:text-black hover:bg-gray-500 focus:bg-white focus:placeholder-gray-500"
            placeholder="Search..."
        />
    </div>

    <div class="relative w-10" x-data="{ show: false }">
        <!-- Dropdown button -->
        <button
            @click="show = true"
            class="border-2 border-transparent rounded-full  focus:outline-none ring-2 ring-transparent focus:ring-white"
        >
            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full" />
        </button>

        <!-- Dropdown menu -->
        <div
            x-show="show"
            @click.away="show = false"
            style="display: none"
            class="absolute right-0 z-10 w-48 py-1 mt-2 bg-white rounded-md shadow-lg  focus:outline-none"
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
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:bg-gray-100"
            >
                Your Profile
            </a>
            <a
                href="javascript:;"
                onclick="document.querySelector('#logout-form').submit()"
                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 focus:bg-gray-100"
            >
                Sign out
            </a>
        </div>

        <!-- Logout form -->
        <form action="{{ route('logout') }}" method="post" id="logout-form">@csrf</form>
    </div>
</nav>
