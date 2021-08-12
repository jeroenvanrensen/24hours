@props(['name' => 'modal', 'title'])

<div
    class="fixed inset-0 z-30"
    id="modal-{{ $name }}"
    x-data="{ show: false }"
    {{ '@'.$name.'.window'}}="show = true"
    x-show="show"
    @keydown.escape.window="show = false"
    x-init="
        $watch('show', isOpen =>  {
            $nextTick(() => { document.querySelector('#modal-{{ $name }} input').focus(); });
        });
    "
>
    <div
        x-show="show"
        class="absolute inset-0 z-30"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="w-full h-full bg-black opacity-40"></div>
    </div>

    <div class="absolute z-40 flex items-center justify-center w-full h-full">
        <div
            x-show="show"
            @click.away="show = false"
            class="w-full max-w-lg overflow-hidden bg-white rounded-lg shadow-lg"
            x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition transform ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="p-8 pb-8">
                <h3 class="mb-4 text-xl font-medium">{{ $title }}</h3>
                
                {{ $slot }}
            </div>

            <div class="flex items-center justify-end px-8 py-4 space-x-4 bg-gray-50">
                <x-button secondary @click="show = false">Cancel</x-button>
                {{ $footer ?? null }}
            </div>
        </div>
    </div>
</div>