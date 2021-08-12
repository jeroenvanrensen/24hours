<x-modal name="new-member" title="Invite member">
    @if(session()->has('success'))
        <p class="mb-6 font-semibold text-green-600 dark:text-green-300">{{ session()->get('success') }}</p>
    @endif

    <!-- Email -->
    <x-form-group>
        <x-label for="email">Email</x-label>
        <x-input type="text" name="email" id="email" wire:model.lazy="email" />
        <x-form-error name="email" />
    </x-form-group>

    <!-- Role -->
    <x-form-group>
        <x-label for="role">Role</x-label>
        <x-select name="role" id="role" wire:model.lazy="role">
            <option value="member">Member</option>
            <option value="viewer">Viewer</option>
        </x-select>
        <x-form-error name="role" />
        @unless($errors->has('role'))
            <div class="mt-4 mb-10 text-sm text-gray-600">Members can add, edit and delete links and notes. Viewers can only see items. Only the board owner (you) can edit the board or invite people.</div>
        @endunless
    </x-form-group>

    <x-slot name="footer">
        <x-button wire:click="invite">Invite member</x-button>
    </x-slot>
</x-modal>
