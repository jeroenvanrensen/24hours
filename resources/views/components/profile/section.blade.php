<div class="mb-12">
    <div class="grid-cols-3 gap-8 md:grid">
        <!-- Left -->
        <div class="col-span-1 mb-4 md:mb-0">
            <div class="flex items-center mb-2">
                <div class="w-6 h-6 mr-2 text-gray-600 dark:text-gray-400">
                    {{ $icon }}
                </div>

                <h2 class="text-2xl">{{ $title }}</h2>
            </div>

            <p>{{ $description }}</p>
        </div>

        <!-- Right -->
        <div class="col-span-2">
            {{ $card }}
        </div>
    </div>
</div>