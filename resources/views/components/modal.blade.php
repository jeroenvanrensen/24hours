@props(['name' => 'showModal'])

<div x-show="{{ $name }}" class="px-6 fixed w-full h-screen inset-0 flex items-center justify-center z-50" style="display: none;" id="add-link-modal">
    <div @click="{{ $name }} = false" class="absolute w-full h-full bg-gray-600 opacity-60 dark:bg-black"></div>

    <div class="p-8 z-10 bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-xl w-full">
        <div class="mb-8 flex items-center justify-between">
            <!-- Title -->
            <h2 class="text-2xl font-semibold">{{ $title }}</h2>

            <!-- Close button -->
            <button @click="{{ $name }} = false" class="text-gray-400 hover:text-gray-500 focus:text-gray-600 focus:outline-none dark:hover:text-gray-300 dark:focus:text-gray-200">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{ $slot }}
    </div>
</div>