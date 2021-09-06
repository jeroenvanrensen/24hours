<div>
    <ul class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach($items as $item) @include('items.types.' . strtolower(class_basename($item)),
        ['board' => $board]) @endforeach
    </ul>

    @if(count($items) == 0)
    <p> You don't have any items yet. </p>
    @endif
</div>
