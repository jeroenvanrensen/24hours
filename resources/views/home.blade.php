<div class="w-full min-h-screen bg-gray-200 dark:bg-gray-900">
    <!-- Hero -->
    <div class="max-w-6xl px-6 mx-auto mt-8 md:mt-32">
        <div class="text-center">
            <h1 class="text-3xl font-bold md:text-5xl">Bring your projects to life.</h1>
            <p
                class="max-w-xl mx-auto mt-4 mb-8 text-lg text-gray-700  md:mt-8 md:mb-10 dark:text-gray-400"
                >24Hours is a productivity tool designed to keep your projects moving forward and
                your head clear.</p
            >
            <x-button link href="{{ route('register') }}" class="py-3">Sign up for free</x-button>
        </div>

        <img
            src="{{ asset('img/screenshot.png') }}"
            class="mx-auto mt-20 rounded shadow-sm md:mt-32 md:rounded-xl"
        />
    </div>

    <!-- Dark background -->
    <div class="pt-32 bg-gray-800 -mt-28 md:-mt-72 md:pt-96">&nbsp;</div>

    <!-- Features -->
    <div class="max-w-5xl px-6 py-12 mx-auto md:py-24">
        <div class="mb-8 md:mb-16 md:text-center">
            <h2 class="font-semibold tracking-wide text-blue-800 uppercase dark:text-blue-400"
                >Features</h2
            >
            <p
                class="mt-2 mb-4 text-3xl font-bold leading-8 tracking-tight text-gray-900  md:mt-4 dark:text-white"
                >Space to organize all your ideas.</p
            >
        </div>

        <div class="grid-cols-2 gap-8 md:grid lg:gap-6">
            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"
                    ><svg
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"
                        /></svg
                ></x-slot>
                <x-slot name="title">Organize everything</x-slot>
                <x-slot name="description"
                    >You can create unlimited boards to organize every project.</x-slot
                >
            </x-home.feature>

            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"
                    ><svg
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"
                        /></svg
                ></x-slot>
                <x-slot name="title">Save from the web</x-slot>
                <x-slot name="description"
                    >Found an article you want to read later? Save it and find it easily
                    back.</x-slot
                >
            </x-home.feature>

            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"
                    ><svg
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                        /></svg
                ></x-slot>
                <x-slot name="title">Clean your head</x-slot>
                <x-slot name="description"
                    >Create notes to clear your head and write everything down in a nice
                    editor.</x-slot
                >
            </x-home.feature>

            <!-- Grid item -->
            <x-home.feature>
                <x-slot name="icon"
                    ><svg
                        class="w-6 h-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        /></svg
                ></x-slot>
                <x-slot name="title">Find anything</x-slot>
                <x-slot name="description"
                    >Lost anything? Find it back with the powerful search feature.</x-slot
                >
            </x-home.feature>
        </div>
    </div>

    <!-- Stats -->
    <div class="py-20 bg-gray-800 md:py-24">
        <div class="max-w-2xl px-6 mx-auto">
            <h2 class="mb-12 text-3xl font-bold text-center text-white">24Hours in numbers</h2>

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
    <div class="py-16 text-center md:py-24">
        <x-button link href="{{ route('register') }}" class="py-3">Sign up for free</x-button>
    </div>

    <!-- Footer -->
    <div class="py-8 bg-gray-300 md:py-6 lg:py-8 dark:bg-gray-800">
        <div class="max-w-6xl px-6 mx-auto">
            &copy; Copyright {{ date('Y') }} by
            <a
                href="https://www.jeroenvanrensen.nl/"
                class="underline focus:text-gray-500 focus:outline-none"
                target="_blank"
                >Jeroen van Rensen</a
            >
        </div>
    </div>
</div>
