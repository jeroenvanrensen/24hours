<x-card
    :link="route('links.show', $item)"
    :image="$item->image ?? $item->default_image"
    :altText="$item->title"
    :title="$item->title"
    :description="$item->host"
    target="_blank"
    deleteButton="delete-link-{{ $item->id }}"
>
    <x-slot name="modal">
        <x-modal name="delete-link-{{ $item->id }}" title="Delete link">
            <p class="mb-4 text-gray-700">Are you sure you want to delete this link?</p>
            <p class="font-semibold">{{ $item->title }}</p>

            <x-slot name="footer">
                <x-button wire:click="deleteLink({{ $item->id }})">Delete</x-button>
            </x-slot>
        </x-modal>
    </x-slot>
</x-card>
