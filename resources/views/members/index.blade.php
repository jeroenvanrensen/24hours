<div x-data @keydown.window.escape="!$store.modalOpen && Turbolinks.visit('{{ route('boards.show', $board) }}');">
    <x-navbar />

    <x-panel>
        <h1 x-data class="flex items-center justify-between max-w-full mb-10 space-x-6 overflow-x-auto overflow-y-hidden text-3xl font-semibold">
            <span class="flex-shrink-0">Board members</span>

            <div class="flex-shrink-0 space-x-3">
                <x-button secondary link :href="route('boards.show', $board)">Back</x-button>
                @can('manageMemberships', $board)
                <x-button @click="$dispatch('new-member')">Invite member</x-button>
                @endcan
                @can('leave', $board)
                <x-button color="red" @click="$dispatch('leave-board')">Leave board</x-button>
                @endcan
            </div>
        </h1>

        <ul>
            <li class="flex items-center mb-6 space-x-4">
                <img src="{{ $board->user->avatar }}" alt="{{ $board->user->name }}'s avatar" class="w-10 h-10 rounded-full" />

                <div>
                    <h5 class="font-semibold leading-5">{{ $board->user->name }}</h5>
                    <p class="text-sm leading-5 text-gray-700 dark:text-gray-300">Owner</p>
                </div>
            </li>

            @foreach($board->memberships as $membership)
            <li class="flex items-center mb-6 space-x-4">
                <img src="{{ $membership->user->avatar }}" alt="{{ $membership->user->name }}'s avatar" class="w-10 h-10 rounded-full" />

                <div>
                    <h5 class="font-semibold leading-5">{{ $membership->user->name }}</h5>
                    <p class="text-sm leading-5 text-gray-700 dark:text-gray-300">
                        {{ ucfirst($membership->role) }}
                        @can('manageMemberships', $board) &bullet; <x-link :href="route('members.edit', [$board, $membership])">Edit</x-link> @endcan
                    </p>
                </div>
            </li>
            @endforeach
            
            @foreach($board->invitations as $invitation)
            <li class="flex items-center mb-6 space-x-4">
                <img src="{{ $invitation->avatar }}" alt="{{ $invitation->email }}'s avatar" class="w-10 h-10 rounded-full" />

                <div>
                    <h5 class="font-semibold leading-5">{{ $invitation->email }}</h5>
                    <p class="text-sm leading-5 text-gray-700 dark:text-gray-300">
                        {{ ucfirst($invitation->role) }}
                        &bullet; Invited
                        @can('manageMemberships', $board) &bullet; <x-link button wire:click="deleteInvitation({{ $invitation->id }})">Remove</x-link> @endcan
                    </p>
                </div>
            </li>
            @endforeach
        </ul>

        <x-modal name="new-member" title="Invite member">
            <livewire:members.create :board="$board" />
        </x-modal>

        <x-modal name="leave-board" title="Leave board">
            <p class="mb-4 text-gray-700 dark:text-gray-200">
                Are you sure you want to leave this board? After you have submitted you don't have
                access to any of the board's items anymore.
            </p>
            
            <p>
                <strong>{{ $board->name }}</strong> by {{ $board->user->name }}
            </p>

            <x-slot name="footer">
                <x-button wire:click="leave">Leave board</x-button>
            </x-slot>
        </x-modal>
    </x-panel>
</div>
