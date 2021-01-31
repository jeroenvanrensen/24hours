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

    @push('styles')
        <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" />
    @endpush

    @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    @endpush

    <div wire:ignore class="max-w-2xl mx-auto">
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
</div>
