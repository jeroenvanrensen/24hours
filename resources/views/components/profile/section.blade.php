<div class="mb-12">
    <div class="md:grid grid-cols-3 gap-8">
        <!-- Left -->
        <div class="mb-4 md:mb-0 col-span-1">
            <div class="flex items-center mb-2">
                <div class="w-6 h-6 mr-2 text-gray-600">
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