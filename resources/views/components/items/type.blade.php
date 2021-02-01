@props(['newTab' => false])

<li>
    <a href="{{ $url }}" class="block group border border-gray-200 rounded-lg focus:outline-none overflow-hidden" {{ $newTab ? 'target="_blank"' : '' }}>
        <!-- Image -->
        <div class="h-40 w-full bg-gray-200 transition group-hover:opacity-75 group-focus:opacity-50 flex items-center justify-center">
            {{ $image }}
        </div>

        <div class="px-6 py-4">
            <!-- Title -->
            <span class="block mb-2 font-semibold">{{ $title }}</span>

            <!-- Meta -->
            <span class="inline-flex items-center bg-gray-100 py-px px-2 rounded-full text-sm font-semibold">
                {{ $meta }}
            </span>
        </div>
    </a>
</li>
