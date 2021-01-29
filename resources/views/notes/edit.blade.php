<div>
    <x-slot name="navbar">
        <div class="py-8 px-12 flex items-center justify-between">
            <div class="flex items-center">
                <a href="{{ route('boards.show', $note->board) }}" class="block mr-5 p-2 rounded-full bg-gray-100 hover:bg-gray-300 focus:outline-none focus:bg-gray-300">
                    <svg class="w-5 h-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <span class="font-semibold">{{ $note->title }}</span>
            </div>
        </div>
    </x-slot>

    <!-- Body -->
    <x-forms.group>
        <x-forms.label for="body">Body</x-forms.label>
        <x-forms.input type="text" name="body" id="body" wire:model="body" />
        <x-forms.error name="body" />
    </x-forms.group>
</div>
