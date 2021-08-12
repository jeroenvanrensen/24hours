<div>
    <ul class="grid grid-cols-4 gap-8">
        @foreach($items as $item) @include('items.types.' . strtolower(class_basename($item)),
        ['board' => $board]) @endforeach
    </ul>

    @if(count($items) == 0)
    <p> You don't have any items yet. </p>
    @endif
</div>
