<div>
    <x-navbar />

    <div
        x-data
        @keydown.window.escape.prevent="!$store.modalOpen && Turbolinks.visit('{{ route('boards.show', $note->board) }}');"
        class="max-w-4xl mx-auto mt-10 mb-20"
    >
        <div class="flex items-center justify-center mb-10 space-x-3">
            <button
                class="px-6 py-3 text-sm font-medium rounded-md focus:outline-none {{
                    $tab === 'write'
                        ? 'bg-indigo-100 text-indigo-800 focus:bg-indigo-100'
                        : 'hover:bg-gray-100 text-gray-800 focus:bg-gray-100'
                }} "
                wire:click="$set('tab', 'write')"
            >
                Write
            </button>
            <button
                class="px-6 py-3 text-sm font-medium rounded-md focus:outline-none {{
                    $tab === 'preview'
                        ? 'bg-indigo-100 text-indigo-800 focus:bg-indigo-100'
                        : 'hover:bg-gray-100 text-gray-800 focus:bg-gray-100'
                }} "
                wire:click="$set('tab', 'preview')"
            >
                Preview
            </button>
        </div>
    
        @if($tab === 'write')
        <textarea
            x-ref="textarea"
            class="w-full px-4 py-3 overflow-y-hidden font-mono border border-gray-200 rounded-md shadow-sm focus:border-gray-300 focus:outline-none"
            autofocus
            wire:model="body"
            wire:ignore
            x-init="$nextTick(() => { $refs.textarea.style.height = $refs.textarea.scrollHeight + 'px' })"
            @input="$refs.textarea.style.height = $refs.textarea.scrollHeight + 'px'"
        ></textarea>
        @else
        <div class="prose prose-indigo max-w-none"> {!! Str::markdown($body) !!} </div>
        @endif
    </div>
</div>
