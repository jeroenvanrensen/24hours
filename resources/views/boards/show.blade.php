<div x-data="{ showModal: false }" x-init="$wire.on('hideModal', () => {showModal = false});">
    <x-heading>{{ $board->name }}</x-heading>

    <!-- Add link button -->
    <button @click="showModal = true" class="fixed bottom-12 right-12 p-3 bg-blue-800 hover:bg-blue-900 rounded-full transition shadow-lg focus:outline-none focus:bg-blue-900">
        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
    </button>

    <!-- Add link modal -->
    <livewire:links.create :board="$board" />
</div>
