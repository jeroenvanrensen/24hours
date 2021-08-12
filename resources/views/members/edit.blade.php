<div>
    <x-navbar />

    <x-panel>
        <h1 class="mb-8 text-3xl font-semibold">Edit membership</h1>
    
        <!-- Email -->
        <x-form-group>
            <x-label for="email">Email</x-label>
            <x-input type="text" name="email" id="email" readonly value="{{ $membership->user->email }}" />
            <div class="mt-2 text-sm text-gray-500">The email can't be updated.</div>
        </x-form-group>
    
        <!-- Role -->
        <x-form-group>
            <x-label for="role">Role</x-label>
            <x-select name="role" id="role" wire:model.lazy="role">
                <option value="member">Member</option>
                <option value="viewer">Viewer</option>
            </x-select>
            <x-form-error name="role" />
        </x-form-group>
    
        <!-- Submit button -->
        <x-card-footer class="flex items-center justify-end">
            <button x-data @click="$dispatch('remove-member')" class="text-gray-500 hover:text-red-700 dark:hover:text-red-500 focus:text-red-700 dark:focus:text-red-500 focus:outline-none">
                <x-heroicon-o-trash class="w-6 h-6" />
            </button>

            <x-button class="mx-4" secondary link href="{{ route('members.index', $board) }}">
                Cancel
            </x-button>

            <x-button wire:click="update">
                Update
            </x-button>
        </x-card-footer>
    
        <livewire:members.delete :board="$board" :membership="$membership" />
    </x-panel>
</div>
