<div>
    <!-- Navbar -->
    <nav class="py-4 md:py-8 px-6 md:px-12 flex items-center justify-between">
        <div class="flex items-center">
            <a href="{{ route('boards.show', $note->board) }}" class="block mr-2 md:mr-5 p-2 rounded-full bg-gray-100 hover:bg-gray-300 focus:outline-none focus:bg-gray-300 dark:bg-gray-600 dark:focus:bg-gray-500 dark:hover:bg-gray-500">
                <svg class="w-5 h-5 text-gray-600 dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <span class="font-semibold">{{ $note->title }}</span>
        </div>

        <ul>
            @can('manageItems', $note->board)
                <li>
                    <button @click="showModal = true" class="text-gray-500 hover:text-red-600 focus:outline-none dark:text-gray-400 dark:hover:text-red-400">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </li>
            @endcan
        </ul>
    </nav>

    @can('manageItems', $note->board)
        <!-- Delete modal -->
        <x-modal>
            <x-slot name="title">Delete note</x-slot>
            
            <p class="mb-6">Are you sure you want to delete this note?</p>
            <p class="mb-6"><strong>{{ $note->fresh()->title }}</strong></p>

            <div class="flex items-center justify-end">
                <x-button class="mr-2" secondary @click="showModal = false">Cancel</x-button>
                <x-button wire:click="destroy" color="red">Delete Note</x-button>
            </div>
        </x-modal>
    @endcan

    @can('manageItems', $note->board)
        <!-- Editor -->
        <div wire:ignore class="max-w-2xl mx-auto px-6 my-8 md:my-12 dark:placeholder-gray-400">
            <div
                x-data="{}"
                x-ref="quillEditor"
                x-init="
                    toolbarOptions = [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'link', 'code'],
                        ['image', 'blockquote', 'code-block'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }]
                    ];

                    quill = new Quill($refs.quillEditor, {
                        theme: 'bubble',
                        placeholder: 'Clean your head...',
                        modules: {
                            toolbar: toolbarOptions
                        }
                    });

                    quill.on('text-change', function () {
                        $dispatch('input', quill.root.innerHTML);
                    });
                "
                wire:model.debounce="body"
            >
                {!! $body !!}
            </div>
        </div>
    @else
        <div class="ql-editor max-w-2xl mx-auto px-6 my-8 md:my-12">
            {!! $body !!}
        </div>
    @endcan
</div>
