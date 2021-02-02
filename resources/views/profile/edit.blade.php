<div>
    <div class="mb-16 flex items-center justify-between">
        <h1 class="text-3xl">My Profile</h1>
        <x-button class="ml-4" wire:click="logout" loading="logout">Logout</x-button>
    </div>

    <livewire:profile.profile-info />
    <livewire:profile.password />
</div>
