<div>
    <div class="max-w-xl mx-auto">
        <x-heading small>Accept invitation</x-heading>

        <p class="mb-6">Do you want to join this board?</p>

        <p class="mb-6"><strong>{{ $invitation->board->name }}</strong></p>

        <x-button wire:click="accept">Accept</x-button>
        <x-button secondary class="ml-2" wire:click="deny">Deny</x-button>
    </div>
</div>
