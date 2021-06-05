@if(session()->has('flash.success'))
    <div
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        class="fixed flex py-3 pl-4 pr-12 space-x-4 transition transform bg-white border border-gray-300 rounded shadow-lg right-8 bottom-8"
        x-transition:leave="ease-out duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mt-px text-gray-500" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>

        <div>
            <div class="font-semibold">Success!</div>
            <div class="text-sm">{{ session()->get('flash.success') }}</div>
        </div>
    </div>
@endif
