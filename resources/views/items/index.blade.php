<div>
    <ul class="grid grid-cols-3 gap-6">
        @foreach($items as $item)
            @include('items.types.' . strtolower(class_basename($item)))
        @endforeach
    </ul>

    @if(count($items) == 0)
        <p class="-mt-16 text-center">No Items Found.</p>
    @endif

    @if($showButton)
        <div class="mt-6 flex justify-center">
            <x-button secondary class="font-semibold" wire:click="loadMore">Load More</x-button>
        </div>
    @endif
</div>
