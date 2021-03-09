@props([
    'newTab' => false,
    'modalName' => 'showDeleteModalFor' . class_basename($item) . 'Id' . $item->id,
    'item' => null,
    'board' => null
])

<li class="relative" x-data="{ {{ $modalName }}: false }">
    <a href="{{ $url }}" class="block overflow-hidden border border-gray-200 rounded-lg group dark:border-gray-700 focus:outline-none" {{ $newTab ? 'target="_blank"' : '' }}>
        <!-- Image -->
        <div class="flex items-center justify-center w-full transition bg-gray-200 h-36 lg:h-40 dark:bg-gray-700 group-hover:opacity-75 group-focus:opacity-50">
            {{ $image }}
        </div>

        <div class="px-6 py-4">
            <!-- Title -->
            <span class="block mb-2 font-semibold">{{ $item->title }}</span>

            <!-- Meta -->
            <span class="inline-flex items-center flex-1 px-2 py-px text-sm font-semibold bg-gray-100 rounded-full dark:bg-gray-700">
                {{ $meta }}
            </span>
        </div>
    </a>

    @can('manageItems', $board)
        <!-- Delete button -->
        <button @click="{{ $modalName }} = true" class="absolute flex items-center justify-center w-5 h-5 text-gray-600 bg-gray-100 rounded-full top-2 right-2 dark:bg-gray-900 dark:text-gray-400 hover:bg-gray-300 focus:outline-none focus:bg-gray-400 dark:hover:bg-gray-700 dark:focus:bg-gray-500">
            <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </button>
    @endcan

    <!-- Delete Modal -->
    <x-modal :name="$modalName">
        <x-slot name="title">Delete {{ strtolower(class_basename($item)) }}</x-slot>

        <p class="mb-6">Are you sure you want to delete this {{ strtolower(class_basename($item)) }}?</p>
        <p class="mb-6"><strong>{{ $item->title }}</strong></p>

        <div class="flex items-center justify-end">
            <x-button class="mr-2" secondary @click="{{ $modalName }} = false">Cancel</x-button>
            <x-button color="red" wire:click="delete{{ class_basename($item) }}({{ $item }})" loading="delete{{ class_basename($item) }}">Delete</x-button>
        </div>
    </x-modal>
</li>
