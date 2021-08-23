@props(['code', 'message', 'description', 'buttonUrl' => route('home'), 'buttonText' => 'Go back
home'])

<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <!-- Metas -->
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <!-- Title -->
        <title>{{ $code }} {{ $message }} - {{ config('app.name') }}</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

        <!-- Fonts -->
        <link
            href="https://fonts.googleapis.com/css?family=Poppins:100,100italic,200,200italic,300,300italic,regular,italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic"
            rel="stylesheet"
        />
    </head>
    <body class="dark:bg-gray-800 dark:text-white">
        <div class="flex items-center justify-center min-h-screen">
            <div class="flex">
                <h2 class="text-6xl font-bold text-indigo-600 dark:text-indigo-400">{{ $code }}</h2>

                <div>
                    <div class="pl-6 ml-6 border-l border-gray-200 dark:border-gray-500">
                        <h1 class="text-6xl font-bold">{{ $message }}</h1>
                        <p class="mt-4 text-gray-600 dark:text-gray-200">
                            {{ $description }}
                        </p>
                    </div>

                    @if(!empty($buttonText))
                    <div class="pl-px ml-12">
                        <a
                            href="{{ $buttonUrl }}"
                            class="inline-block px-6 py-3 mt-8 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm  hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 dark:focus:ring-indigo-400"
                        >
                            {{ $buttonText }}
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
