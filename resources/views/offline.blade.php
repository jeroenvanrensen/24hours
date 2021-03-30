<div wire:offline>
    <div class="fixed inset-0 z-50 flex items-center justify-center w-full h-screen px-6">
        <div class="absolute w-full h-full">
            <div class="absolute w-full h-full bg-gray-600 opacity-60 dark:bg-black"></div>
        </div>

        <div class="z-10 w-full max-w-xl p-8 bg-white rounded-lg shadow-lg dark:bg-gray-800">
            <h2 class="mb-4 text-2xl font-semibold">You are offline</h2>

            <p>You are currently offline. Please connect to the internet to continue using <strong>{{ config('app.name') }}</strong>.</p>
        </div>
    </div>
</div>
