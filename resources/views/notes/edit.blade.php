<div>
    <x-navbar />

    <div
        x-data
        @keydown.window.escape.prevent="!$store.modalOpen && Turbolinks.visit('{{ route('boards.show', $note->board) }}');"
        class="max-w-4xl px-6 mx-auto mt-6 mb-6 md:mt-10 md:mb-10 lg:mb-20"
    >
        <div class="flex items-center justify-center mb-6 space-x-3 md:mb-10">
            <button
                class="px-6 py-3 text-sm font-medium rounded-md focus:outline-none {{
                    $tab === 'write'
                        ? 'bg-indigo-100 text-indigo-800 focus:bg-indigo-100 dark:bg-gray-600 dark:text-white dark:focus:bg-gray-600'
                        : 'hover:bg-gray-100 text-gray-800 focus:bg-gray-100 dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:text-white'
                }} "
                wire:click="$set('tab', 'write')"
            >
                Write
            </button>
            <button
                class="px-6 py-3 text-sm font-medium rounded-md focus:outline-none {{
                    $tab === 'preview'
                        ? 'bg-indigo-100 text-indigo-800 focus:bg-indigo-100 dark:bg-gray-600 dark:text-white dark:focus:bg-gray-600'
                        : 'hover:bg-gray-100 text-gray-800 focus:bg-gray-100 dark:hover:bg-gray-600 dark:focus:bg-gray-600 dark:text-white'
                }} "
                wire:click="$set('tab', 'preview')"
            >
                Preview
            </button>
        </div>
    
        @if($tab === 'write')
        <textarea
            x-ref="textarea"
            class="w-full px-4 py-3 overflow-y-hidden font-mono border border-gray-200 rounded-md shadow-sm dark:border-gray-600 dark:focus:border-gray-500 dark:bg-gray-800 focus:border-gray-300 focus:outline-none"
            autofocus
            wire:model="body"
            wire:ignore
            x-init="$nextTick(() => { $refs.textarea.style.height = $refs.textarea.scrollHeight + 'px' })"
            @input="$refs.textarea.style.height = $refs.textarea.scrollHeight + 'px'"
        ></textarea>
        @else
        <div class="prose dark:prose-dark prose-indigo max-w-none"> {!! Str::markdown($body) !!} </div>
        @endif
    </div>
</div>
