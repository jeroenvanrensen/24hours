<div>
    <div class="mb-16 flex items-center justify-between">
        <h1 class="text-3xl md:text-4xl font-serif">My Profile</h1>
        <x-button class="ml-4" wire:click="logout" loading="logout">Logout</x-button>
    </div>

    <livewire:profile.profile-info />
    <livewire:profile.password />
    <livewire:profile.delete-account />
</div>
