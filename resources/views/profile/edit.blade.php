<div>
    <div class="flex items-center justify-between mb-16">
        <h1 class="font-serif text-3xl md:text-4xl">My Profile</h1>
        <x-button class="ml-4" wire:click="logout" loading="logout">Logout</x-button>
    </div>

    <livewire:profile.profile-info />
    <livewire:profile.password />
    <livewire:profile.delete-account />
</div>
