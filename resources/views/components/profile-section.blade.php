<x-container>
    <div class="grid grid-cols-4 gap-24">
        <div>
            <ul class="-mx-6">
                <li class="mb-1">
                    <a class="flex items-center px-6 py-3 space-x-3 font-medium text-gray-800 rounded-md {{ request()->routeIs('profile.edit') ? 'bg-gray-100 focus:bg-gray-200' : 'focus:bg-gray-100' }}" href="{{ route('profile.edit') }}">
                        <x-heroicon-o-identification class="w-6 h-6 text-gray-700" />
                        <span>Profile info</span>
                    </a>
                </li>
                
                <li class="mb-1">
                    <a class="flex items-center px-6 py-3 space-x-3 font-medium text-gray-800 rounded-md {{ request()->routeIs('profile.avatar') ? 'bg-gray-100 focus:bg-gray-200' : 'focus:bg-gray-100' }}" href="{{ route('profile.avatar') }}">
                        <x-heroicon-o-user-circle class="w-6 h-6 text-gray-700" />
                        <span>Avatar</span>
                    </a>
                </li>
                
                <li class="mb-1">
                    <a class="flex items-center px-6 py-3 space-x-3 font-medium text-gray-800 rounded-md {{ request()->routeIs('profile.password') ? 'bg-gray-100 focus:bg-gray-200' : 'focus:bg-gray-100' }}" href="{{ route('profile.password') }}">
                        <x-heroicon-o-key class="w-6 h-6 text-gray-700" />
                        <span>Update password</span>
                    </a>
                </li>
                
                <li class="mb-1">
                    <a class="flex items-center px-6 py-3 space-x-3 font-medium text-gray-800 rounded-md {{ request()->routeIs('profile.delete') ? 'bg-gray-100 focus:bg-gray-200' : 'focus:bg-gray-100' }}" href="{{ route('profile.delete') }}">
                        <x-heroicon-o-trash class="w-6 h-6 text-gray-700" />
                        <span>Delete account</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="col-span-3">
            <h3 class="mb-2 text-2xl font-semibold">{{ $title }}</h3>
            <p class="mb-6 text-lg text-gray-700">{{ $description }}</p>

            {{ $slot }}
        </div>
    </div>
</x-container>
