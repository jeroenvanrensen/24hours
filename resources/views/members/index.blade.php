<div x-data="{ newMemberModal: false, showLeaveBoardMoadal: false }" class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <h2 class="text-2xl md:text-3xl font-serif">Members</h2>

        @can('edit', $board)
            <x-button @click="newMemberModal = true">Add member</x-button>
        @endcan
        @can('leave', $board)
            <x-button color="red" @click="showLeaveBoardMoadal = true">Leave board</x-button>
        @endcan
    </div>

    <ul>
        <li class="mb-6">
            <strong class="block">{{ $board->user->name }}</strong>
            <span>Owner</span>
        </li>

        @foreach($board->memberships as $membership)
            <li class="mb-6">
                <strong class="block">{{ $membership->user->name }}</strong>
                <span>{{ ucfirst($membership->role) }}</span>
            </li>
        @endforeach

        @foreach($board->invitations as $invitation)
            <li class="mb-6 text-gray-500">
                <strong class="block">{{ $invitation->email }}</strong>
                <span>Invited - {{ ucfirst($invitation->role) }}</span>
            </li>
        @endforeach
    </ul>

    <livewire:members.create :board="$board" />

    <x-modal name="showLeaveBoardMoadal">
        <x-slot name="title">Leave board</x-slot>

        <p class="mb-4">Are you sure you want to leave this board? After you have submitted you don't have access to any of the board's items anymore.</p>
        <p class="mb-8"><strong>{{ $board->name }}</strong> by {{ $board->user->name }}</p>

        <div class="flex items-center justify-end">
            <x-button class="mr-4" @click="showLeaveBoardMoadal = false" secondary>Cancel</x-button>
            <x-button color="red" wire:click="leave">Leave board</x-button>
        </div>
    </x-modal>
</div>
