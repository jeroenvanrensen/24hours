<div x-data @keydown.escape.window="!$store.modalOpen && Turbolinks.visit('{{ route('boards.index') }}')">
    <x-container>
        <div class="md:grid md:gap-24 md:grid-cols-4">
            <div>
                <ul class="md:-mx-6">
                    <x-profile-button text="Profile info" icon="identification" :url="route('profile.edit')" />
                    <x-profile-button text="Avatar" icon="user-circle" :url="route('profile.avatar')" />
                    <x-profile-button text="Update password" icon="key" :url="route('profile.password')" />
                    <x-profile-button text="Delete account" icon="trash" :url="route('profile.delete')" />
                </ul>
            </div>

            <div class="col-span-3">
                <h3 class="mb-2 text-2xl font-semibold">{{ $title }}</h3>
                <p class="mb-6 text-lg text-gray-700 dark:text-gray-200">{{ $description }}</p>

                {{ $slot }}
            </div>
        </div>
    </x-container>
</div>
