<div class="bg-blue-100">
    <!-- Navbar -->
    <nav class="flex items-center justify-between px-24 pt-8 mb-24">
        <a href="{{ route('home') }}" class="text-xl font-semibold text-blue-800">24Hours</a>

        <div class="flex items-center space-x-6">
            <a class="flex items-center space-x-1 font-semibold text-blue-800" href="{{ route('login') }}">
                <x-heroicon-o-login class="w-5 h-5" />
                <span>Login</span>
            </a>
            <a class="flex items-center space-x-1 font-semibold text-blue-800" href="{{ route('register') }}">
                <x-heroicon-o-user-add class="w-5 h-5" />
                <span>Register</span>
            </a>
        </div>
    </nav>

    <!-- Hero section -->
    <div class="flex items-center mb-24">
        <div class="relative w-1/3">
            <div class="absolute flex flex-col justify-center h-full mr-32 -mt-4 left-24">
                <h1 class="mb-8 text-3xl font-semibold text-blue-800">What is 24Hours?</h1>
                <p class="text-lg font-thin">24Hours is a productivity tool designed to keep your projects moving forward and your head clear.</p>
                <div class="mt-10">
                    <a href="{{ route('register') }}" class="px-4 py-2 font-semibold text-white bg-blue-800 rounded-md hover:bg-blue-900">Sign up for Free</a>
                </div>
            </div>
            
            <img src="{{ asset('img/shape1.svg') }}" class="w-full" alt="" />
        </div>

        <div class="flex justify-end flex-1 mr-24">
            <div class="w-2/3">
                <img src="{{ asset('img/screenshot.png') }}" class="rounded-lg shadow-lg" alt="Screenshot" />
            </div>
        </div>
    </div>

    <!-- Features section -->
    <div class="flex justify-end mb-24">
        <div class="relative w-1/2">
            <img src="{{ asset('img/shape2.svg') }}" alt="" class="w-full" />
            <div class="absolute top-0 flex flex-col justify-center w-full h-full py-24 pl-64 pr-24">
                <h1 class="mb-8 text-3xl font-semibold text-blue-800">Features</h1>
                
                <div class="flex mb-6 space-x-4">
                    <x-heroicon-o-duplicate class="w-8 h-8 text-gray-700" />
                    <div>
                        <h4 class="mb-1 text-lg font-semibold">Organize everything</h4>
                        <p class="text-gray-800">You can create unlimited boards to organize every project.</p>
                    </div>
                </div>
                
                <div class="flex mb-6 space-x-4">
                    <x-heroicon-o-pencil-alt class="w-8 h-8 text-gray-700" />
                    <div>
                        <h4 class="mb-1 text-lg font-semibold">Clean your head</h4>
                        <p class="text-gray-800">Create notes to clear your head and write everything down in a nice editor.</p>
                    </div>
                </div>
                
                <div class="flex mb-6 space-x-4">
                    <x-heroicon-o-link class="w-8 h-8 text-gray-700" />
                    <div>
                        <h4 class="mb-1 text-lg font-semibold">Save from the web</h4>
                        <p class="text-gray-800">Found an article you want to read later? Save it and find it easily back.</p>
                    </div>
                </div>
                
                <div class="flex space-x-4">
                    <x-heroicon-o-search class="w-8 h-8 text-gray-700" />
                    <div>
                        <h4 class="mb-1 text-lg font-semibold">Find anything</h4>
                        <p class="text-gray-800">Lost anything? Find it back with the powerful search feature.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Counters section -->
    <div class="py-10 mx-24 mb-48 bg-blue-800 rounded-lg shadow-lg">
        <h2 class="mb-12 text-2xl font-semibold text-center text-white">24Hours in numbers</h2>

        <div class="grid max-w-4xl grid-cols-4 mx-auto">
            <h3 class="font-semibold text-center text-white text-7xl">
                <span class="block -mb-8">{{ \App\Models\User::count() }}</span>
                <span class="text-xl">Users</span>
            </h3>
            <h3 class="font-semibold text-center text-white text-7xl">
                <span class="block -mb-8">{{ \App\Models\Board::count() }}</span>
                <span class="text-xl">Boards</span>
            </h3>
            <h3 class="font-semibold text-center text-white text-7xl">
                <span class="block -mb-8">{{ \App\Models\Link::count() }}</span>
                <span class="text-xl">Notes</span>
            </h3>
            <h3 class="font-semibold text-center text-white text-7xl">
                <span class="block -mb-8">{{ \App\Models\Note::count() }}</span>
                <span class="text-xl">Links</span>
            </h3>
        </div>
    </div>

    <!-- Call to action -->
    <div class="flex justify-center mb-24">
        <a href="{{ route('register') }}" class="px-4 py-2 font-semibold text-white bg-blue-800 rounded-md hover:bg-blue-900">Sign up for Free</a>
    </div>

    <!-- Footer -->
    <footer class="pb-6">
        <p class="text-sm text-center text-gray-600">
            Copyright &copy; {{ date('Y') }} by <a target="_blank" href="https://www.jeroenvanrensen.nl/" class="underline">Jeroen van Rensen</a>.
        </p>
    </footer>
</div>
