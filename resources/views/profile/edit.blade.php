<div>
    <x-navbar />

    <x-container x-data @keydown.window.escape="Turbolinks.visit('{{ route('boards.index') }}');">
        <h1 class="mb-10 text-3xl font-bold">My Profile</h1>

        <livewire:profile.profile-info />
        <livewire:profile.password />
        <livewire:profile.delete-account />
    </x-container>
</div>
