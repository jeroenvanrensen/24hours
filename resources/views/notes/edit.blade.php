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
