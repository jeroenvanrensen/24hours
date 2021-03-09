<x-modal name="newMemberModal">
    <x-slot name="title">Add member</x-slot>

    @if(session()->has('success'))
        <p class="mb-6 font-semibold text-green-600 dark:text-green-300">{{ session()->get('success') }}</p>
    @endif

    <!-- Email -->
    <x-forms.group>
        <x-forms.label for="email">Email</x-forms.label>
        <x-forms.input type="text" name="email" id="email" wire:model.lazy="email" />
        <x-forms.error name="email" />
    </x-forms.group>

    <!-- Role -->
    <x-forms.group>
        <x-forms.label for="role">Role</x-forms.label>
        <x-forms.select name="role" id="role" wire:model.lazy="role">
            <option value="member">Member</option>
            <option value="viewer">Viewer</option>
        </x-forms.select>
        <x-forms.error name="role" />
        @unless($errors->has('role'))
            <div class="mt-4 mb-10 text-sm font-semibold text-gray-600 dark:text-gray-400">Members can add, edit and delete links and notes. Viewers can only see items. Only the board owner (you) can edit the board or invite people.</div>
        @endunless
    </x-forms.group>

    <div class="flex items-center justify-end">
        <x-button secondary class="mr-4" @click="newMemberModal = false">Cancel</x-button>
        <x-button wire:click="invite">Invite member</x-button>
    </div>
</x-modal>
