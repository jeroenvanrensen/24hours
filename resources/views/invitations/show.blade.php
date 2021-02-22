<div>
    <div class="max-w-xl mx-auto">
        <x-heading small>Accept invitation</x-heading>

        <p class="mb-4">Do you want to join this board?</p>

        <p class="mb-8"><strong>{{ $invitation->board->name }}</strong> by {{ $invitation->board->user->name }}</p>

        <x-button wire:click="accept">Accept</x-button>
        <x-button secondary class="ml-2" wire:click="deny">Deny</x-button>
    </div>
</div>
