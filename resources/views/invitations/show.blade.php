<div>
    <x-navbar />

    <x-panel>
        @if($invitation->board->archived)
            <p class="flex items-center mb-8 space-x-2 text-sm font-medium text-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <span>This board is archived. You can't accept the invitation.</span>
            </p>
        @endif

        <h1 class="mb-8 text-3xl font-semibold">Accept invitation</h1>

        <p class="mb-4">Do you want to join this board?</p>

        <p class="mb-8"><strong>{{ $invitation->board->name }}</strong> by {{ $invitation->board->user->name }}</p>

        @if($invitation->board->archived)
            <div class="space-x-3 opacity-50 pointer-events-none">
                <x-button>Accept</x-button>
                <x-button secondary>Deny</x-button>
            </div>
        @else
            <div class="space-x-3">
                <x-button wire:click="accept">Accept</x-button>
                <x-button secondary wire:click="deny">Deny</x-button>
            </div>
        @endif
    </x-panel>
</div>
