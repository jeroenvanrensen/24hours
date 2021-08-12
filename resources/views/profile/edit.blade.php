<div x-data @keydown.window.escape="Turbolinks.visit('{{ route('boards.index') }}');">
    <div class="flex items-center justify-between mb-16">
        <h1 class="font-serif text-3xl md:text-4xl">My Profile</h1>
    </div>

    <livewire:profile.profile-info />
    <livewire:profile.password />
    <livewire:profile.delete-account />
</div>
