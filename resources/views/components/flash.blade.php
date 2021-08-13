@if(session()->has('flash.success'))
    <div
        x-data="{ open: true }"
        x-show="open"
        x-init="setTimeout(() => { open = false }, 5000)"
        class="fixed flex px-5 py-3 space-x-3 bg-white border border-gray-200 rounded-lg shadow-lg bottom-12 right-12"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="transform scale-100 opacity-100"
        x-transition:leave-end="transform scale-90 opacity-0"
    >
        <x-heroicon-o-check-circle class="mt-px -ml-1 text-green-600 w-7 h-7" />

        <div>
            <h6 class="font-medium">Success!</h6>
            <p class="text-sm text-gray-600">{{ session()->get('flash.success') }}</p>
        </div>
    </div>
@endif
