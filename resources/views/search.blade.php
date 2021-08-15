<div
    x-data="search"
    @keydown.window.cmd.k.prevent="$refs.input.focus()"
    @keydown.window.ctrl.k.prevent="$refs.input.focus()"
    @keydown.escape.window.prevent="$refs.input.blur()"
    class="relative w-full max-w-md"
>
    <div class="relative">
        <div class="absolute top-0 flex items-center h-10 pointer-events-none left-4" :class="{ 'text-gray-300': !focus, 'text-gray-400': focus }">
            <x-heroicon-o-search class="w-5 h-5" />
        </div>

        <input
            x-ref="input"
            wire:model="query"
            type="text"
            class="w-full px-4 py-2 text-gray-200 placeholder-gray-300 bg-gray-600 rounded-md cursor-pointer focus:cursor-text hover:bg-gray-500 pl-11 focus:text-black focus:bg-white focus:placeholder-gray-500"
            placeholder="Search..."
            @focusin="focus = true"
            @focusout="focus = false"
            @keydown.down.prevent="$refs.search1.focus()"
        />

        <div class="absolute top-0 flex items-center h-10 text-gray-300 pointer-events-none right-4" :class="{ 'text-gray-300': !focus, 'text-gray-400': focus }">
            <div class="px-1 py-px text-sm border border-gray-400 rounded-md">
                ⌘K
            </div>
        </div>
    </div>
    
    <div
        x-show="focus"
        class="absolute z-20 w-full py-1 mt-3 bg-white border border-gray-100 rounded-md shadow-lg"
        x-transition:enter="transition duration-200 ease-out"
        x-transition:enter-start="transform scale-95 opacity-0"
        x-transition:enter-end="transform scale-100 opacity-100"
        x-transition:leave="transition duration-100 ease-in"
        x-transition:leave-start="transform scale-100 opacity-100"
        x-transition:leave-end="transform scale-95 opacity-0"
        @focusin="focus = true"
        @focusout="focus = false"
    >
        @forelse($results as $result)
        @include('search.types.' . strtolower(class_basename($result)), ['loop' => $loop])
        @empty
        <p class="px-4 py-2 text-gray-500 pointer-events-none">{{ empty($query) ? 'Start typing...' : 'No results found.' }}</p>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('search', () => ({
            focus: false,

            init() {
                this.$watch('focus', hasFocus => {
                    this.$store.modalOpen = hasFocus;
                });
            }
        }))
    })
</script>
