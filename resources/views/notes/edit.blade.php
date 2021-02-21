<div>
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
