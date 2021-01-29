<div x-show="showModal" class="fixed w-full h-screen inset-0 flex items-center justify-center" style="display: none;" id="add-link-modal">
    <div @click="showModal = false" class="absolute w-full h-full bg-black opacity-25"></div>

    <div class="p-8 z-10 bg-white rounded-lg shadow-lg max-w-xl w-full">
        <h2 class="mb-6 text-xl font-semibold">{{ $title }}</h2>

        {{ $slot }}
    </div>
</div>