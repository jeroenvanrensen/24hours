<div
    x-data="search"
    @keydown.window.cmd.k.prevent="$refs.input.focus(); checkForFocus();"
    @keydown.window.ctrl.k.prevent="$refs.input.focus(); checkForFocus();"
    @keydown.escape.window.prevent="$refs.input.blur(); checkForFocus();"
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
            class="w-full px-4 py-2 text-gray-200 placeholder-gray-300 bg-gray-600 rounded-md hover:bg-gray-500 pl-11 focus:text-black focus:bg-white focus:placeholder-gray-500"
            :class="{ 'cursor-pointer': !focus }"
            placeholder="Search..."
            @click="checkForFocus()"
            @click.away="checkForFocus()"
        />

        <div class="absolute top-0 flex items-center h-10 text-gray-300 pointer-events-none right-4" :class="{ 'text-gray-300': !focus, 'text-gray-400': focus }">
            <div class="px-1 py-px text-sm border border-gray-400 rounded-md">
                ⌘K
            </div>
        </div>
    </div>
    
    <div
        style="display: none;"
        x-show="focus"
        class="absolute z-20 w-full py-1 mt-3 bg-white border border-gray-100 rounded-md shadow-lg"
        x-transition:enter="transition duration-200 ease-out"
        x-transition:enter-start="transform scale-95 opacity-0"
        x-transition:enter-end="transform scale-100 opacity-100"
        x-transition:leave="transition duration-100 ease-in"
        x-transition:leave-start="transform scale-100 opacity-100"
        x-transition:leave-end="transform scale-95 opacity-0"
    >
        @forelse($results as $result)
        @include('search.types.' . strtolower(class_basename($result)))
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
            },

            checkForFocus() {
                this.focus = document.activeElement === this.$refs.input ? true : false;
            }
        }))
    })
</script>
