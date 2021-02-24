<div x-data="{ showRemoveMemberModal: false }" class="max-w-2xl mx-auto">
    <x-heading small>Edit membership</x-heading>

    <!-- Email -->
    <x-forms.group>
        <x-forms.label for="email">Email</x-forms.label>
        <x-forms.input type="text" name="email" id="email" readonly value="{{ $membership->user->email }}" />
        <div class="mt-1 text-gray-500">The email can't be updated.</div>
    </x-forms.group>

    <!-- Role -->
    <x-forms.group>
        <x-forms.label for="role">Role</x-forms.label>
        <x-forms.select name="role" id="role" wire:model.lazy="role">
            <option value="member">Member</option>
            <option value="viewer">Viewer</option>
        </x-forms.select>
        <x-forms.error name="role" />
    </x-forms.group>

    <!-- Submit button -->
    <div class="flex items-center justify-end">
        <button @click="showRemoveMemberModal = true" class="text-gray-500 hover:text-red-700 dark:hover:text-red-500 focus:text-red-700 dark:focus:text-red-500 focus:outline-none">
            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>
        </button>
        <x-button class="mx-4" secondary link href="{{ route('members.index', $board) }}">Cancel</x-button>
        <x-button wire:click="update">Update</x-button>
    </div>

    <livewire:members.delete :board="$board" :membership="$membership" />
</div>
