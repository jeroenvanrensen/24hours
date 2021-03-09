<div>
    <ul class="grid grid-cols-1 gap-6 md:grid-cols-3">
        @foreach($items as $item)
            @include('items.types.' . strtolower(class_basename($item)), ['board' => $board])
        @endforeach
    </ul>

    @if(count($items) == 0)
        <p class="-mt-16 text-center">No Items Found.</p>
    @endif

    @if($showButton)
        <div class="flex justify-center mt-6">
            <x-button secondary class="font-semibold" wire:click="loadMore">Load More</x-button>
        </div>
    @endif
</div>
