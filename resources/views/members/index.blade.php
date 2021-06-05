<div
    x-data="{ newMemberModal: false, showLeaveBoardMoadal: false }"
    class="max-w-2xl mx-auto"
    @keydown.window.escape="if(!newMemberModal && !showLeaveBoardMoadal) Turbolinks.visit('{{ route('boards.show', $board) }}');"
>
    <x-heading small>
        Board members

        <x-slot name="right">
            @can('edit', $board)
                <x-button @click="newMemberModal = true">Add member</x-button>
            @endcan
            @can('leave', $board)
                <x-button color="red" @click="showLeaveBoardMoadal = true">Leave board</x-button>
            @endcan
        </x-slot>
    </x-heading>

    <ul>
        <li class="mb-6">
            <strong>{{ $board->user->name }}</strong>
            <div>Owner</div>
        </li>

        @foreach($board->memberships as $membership)
            <li class="mb-6">
                <strong>{{ $membership->user->name }}</strong>
                <div class="mb-px">{{ ucfirst($membership->role) }}</div>
                
                @can('edit', $board)
                    <div class="text-sm">
                        <a class="text-gray-500 underline focus:text-gray-400 dark:text-gray-400 dark:focus:text-gray-500" href="{{ route('members.edit', [$board, $membership]) }}">Edit / remove</a>
                    </div>
                @endcan
            </li>
        @endforeach

        @foreach($board->invitations as $invitation)
            <li class="mb-6 text-gray-500">
                <strong>{{ $invitation->email }}</strong>
                <div>Invited - {{ ucfirst($invitation->role) }}</div>
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
