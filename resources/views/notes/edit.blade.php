<div
    x-data="{ showModal: false, showInfoModal: false }"
    @keydown.window.escape="if(!showModal && !showInfoModal) Turbolinks.visit('{{ route('boards.show', $note->board) }}');"
    @can('manageItems', $note->board)
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
                $dispatch('quill-input', quill.root.innerHTML);
            });
        "
        x-on:quill-input="@this.set('body', $event.detail)"
    @endcan
>
    <!-- Navbar -->
    @include('layouts.custom-navbar', [
        'backLink' => route('boards.show', $note->board),
        'backText' => $note->board->name,
        'right' => '
            <div>
                <button @click="showInfoModal = true" class="text-gray-500 hover:text-gray-700 focus:text-gray-900 focus:outline-none">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </button>

                ' . (auth()->user()->can('manageItems', $note->board) ? '
                <button @click="showModal = true" class="text-gray-500 hover:text-red-600 focus:text-red-600 focus:outline-none">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
                ' : '') . '
            </div>
        '
    ])

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

    <!-- Info modal -->
    <x-modal name="showInfoModal">
        <x-slot name="title">Note info</x-slot>

        <p class="mb-6"><strong>Word count: </strong> {{ $note->word_count }}</p>
        
        <div class="flex items-center justify-end">
            <x-button @click="showInfoModal = false">Close</x-button>
        </div>
    </x-modal>

    @can('manageItems', $note->board)
        <!-- Editor -->
        <div wire:ignore class="max-w-2xl px-6 mx-auto my-8 md:my-12 dark:placeholder-gray-400">
            <div x-ref="quillEditor">
                {!! $body !!}
            </div>
        </div>
    @else
        <div class="max-w-2xl px-6 mx-auto my-8 ql-editor md:my-12">
            {!! $body !!}
        </div>
    @endcan
</div>
