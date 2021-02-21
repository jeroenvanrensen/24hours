<div>
    <div class="max-w-xl mx-auto">
        <h1 class="mb-6 font-serif text-3xl">Accept invitation</h1>

        <p class="mb-6">Do you want to join this board?</p>

        <p class="mb-6"><strong>{{ $invitation->board->name }}</strong></p>

        <x-button wire:click="accept">Accept</x-button>
        <x-button secondary class="ml-4" wire:click="deny">Deny</x-button>
    </div>
</div>
