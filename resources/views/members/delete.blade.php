<x-modal name="remove-member" title="Remove member">
    <p class="mb-2 text-gray-700">Are you sure you want to remove this member?</p>
    <p class="mb-2 text-gray-700">This member won't have access to this board anymore.</p>
    <p class="font-medium">{{ $membership->user->name }}</p>

    <x-slot name="footer">
        <x-button wire:click="destroy" color="red">Remove</x-button>
    </x-slot>
</x-modal>
