<div>
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
        <x-button class="mr-4" secondary link href="{{ route('members.index', $board) }}">Cancel</x-button>
        <x-button wire:click="update">Update</x-button>
    </div>
</div>
