<x-card
    :link="route('notes.edit', $item)"
    altText="Note"
    :title="$item->title"
    :description="$item->updated_at->format('F j, Y')"
>
    <x-slot name="icon">
        <x-heroicon-o-pencil-alt class="w-20 h-20" />
    </x-slot>
</x-card>
