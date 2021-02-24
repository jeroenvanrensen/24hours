<x-modal name="showRemoveMemberModal">
    <x-slot name="title">Remove member</x-slot>

    <p class="mb-4">Are you sure you want to remove this member?</p>
    <p class="mb-4">This member won't have access to this board anymore.</p>
    <p class="mb-8 font-bold">{{ $membership->user->name }}</p>

    <div class="flex items-center justify-end">
        <x-button class="mr-4" secondary link href="{{ route('members.index', $board) }}">Cancel</x-button>
        <x-button wire:click="destroy">Remove</x-button>
    </div>
</x-modal>
