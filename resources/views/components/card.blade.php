<a class="group" href="{{ $link }}" {{ $attributes }}>
    <div class="aspect-w-16 aspect-h-10">
        @isset($image)
        <img
            src="{{ $image }}"
            class="object-cover overflow-hidden transition duration-200 rounded-md shadow-lg  group-hover:opacity-80"
            alt="{{ $altText }}"
        />
        @else
        <div
            class="flex items-center justify-center w-full h-full transition duration-200 rounded-md shadow-lg  bg-gradient-to-br from-indigo-600 to-indigo-700 group-hover:opacity-80"
        >
            <div class="absolute w-full h-full opacity-20 bg-pattern"> </div>
            <div class="z-10 text-white">{{ $icon }}</div>
        </div>
        @endif
    </div>

    <h2 class="mt-4 text-lg font-medium">{{ $title }}</h2>
    <p class="text-sm text-gray-500">{{ $description }}</p>
</a>
