<div>
    <ul class="grid grid-cols-3 gap-6">
        @foreach($links as $link)
            <li>
                <a href="{{ route('links.show', $link) }}" target="_blank" class="block group border border-gray-200 rounded-lg focus:outline-none">
                    <!-- Image -->
                    <div class="h-32 w-full bg-gray-200 group-hover:bg-gray-300 group-focus:bg-gray-300"></div>

                    <div class="px-6 py-4">
                        <!-- Title -->
                        <span class="block mb-2 font-semibold">{{ $link->title }}</span>

                        <!-- Host name -->
                        <span class="inline-flex items-center bg-gray-100 py-px px-2 rounded-full text-sm font-semibold">
                            <svg class="mr-1 text-green-600 w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                            </svg>
                            {{ $link->host }}
                        </span>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>

    @if($showButton)
        <div class="mt-6 flex justify-center">
            <x-button secondary class="font-semibold" wire:click="loadMore">Load More</x-button>
        </div>
    @endif
</div>
