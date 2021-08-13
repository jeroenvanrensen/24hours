<div>
    <x-navbar />

    <x-panel
        @keydown.window.escape="Turbolinks.visit('{{ route('boards.show', $board) }}');"
    >
        <h1 x-data class="flex items-center justify-between mb-10 text-3xl font-semibold">
            Board members

            <div class="space-x-3">
                <x-button secondary link :href="route('boards.show', $board)">Back</x-button>
                @can('manageMemberships', $board)
                <x-button @click="$dispatch('new-member')">Add member</x-button>
                @endcan
                @can('leave', $board)
                <x-button color="red" @click="showLeaveBoardMoadal = true">Leave board</x-button>
                @endcan
            </div>
        </h1>

        <ul>
            <li class="flex items-center mb-6 space-x-4">
                <img src="{{ $board->user->avatar }}" alt="{{ $board->user->name }}'s avatar" class="w-10 h-10 rounded-full" />

                <div>
                    <h5 class="font-semibold leading-5">{{ $board->user->name }}</h5>
                    <p class="text-sm leading-5 text-gray-700">Owner</p>
                </div>
            </li>

            @foreach($board->memberships as $membership)
            <li class="flex items-center mb-6 space-x-4">
                <img src="{{ $membership->user->avatar }}" alt="{{ $membership->user->name }}'s avatar" class="w-10 h-10 rounded-full" />

                <div>
                    <h5 class="font-semibold leading-5">{{ $membership->user->name }}</h5>
                    <p class="text-sm leading-5 text-gray-700">
                        {{ ucfirst($membership->role) }}
                        @can('manageMemberships', $board) &bullet; <x-link :href="route('members.edit', [$board, $membership])">Edit</x-link> @endcan
                    </p>
                </div>
            </li>
            @endforeach
            
            @foreach($board->invitations as $invitation)
            <li class="mb-6 ml-14">
                <h5 class="font-semibold leading-5">{{ $invitation->email }}</h5>
                <p class="text-sm leading-5">Invited</p>
            </li>
            @endforeach
        </ul>

        <x-modal name="new-member" title="Invite member">
            <livewire:members.create :board="$board" />
        </x-modal>

        <x-modal name="showLeaveBoardMoadal">
            <x-slot name="title">Leave board</x-slot>

            <p class="mb-4">
                Are you sure you want to leave this board? After you have submitted you don't have
                access to any of the board's items anymore.
            </p>
            
            <p class="mb-8">
                <strong>{{ $board->name }}</strong> by {{ $board->user->name }}
            </p>

            <div class="flex items-center justify-end">
                <x-button class="mr-4" @click="showLeaveBoardMoadal = false" secondary
                    >
                    Cancel
                    </x-button>
                <x-button color="red" wire:click="leave">Leave board</x-button>
            </div>
        </x-modal>
    </x-panel>
</div>
