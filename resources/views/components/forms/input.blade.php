@error($name)

<input {{ $attributes->merge([
    'type' => 'text',
    'class' => 'w-full py-2 px-4 placeholder-gray-600 dark:placeholder-gray-300 rounded-md border focus:outline-none focus:ring-2 focus:ring-opacity-75 border-red-300 focus:border-red-400 focus:ring-red-200 dark:bg-gray-700 dark:border-red-600 dark:focus:ring-red-400'
]) }} />

@else

<input {{ $attributes->merge([
    'type' => 'text',
    'class' => 'w-full py-2 px-4 placeholder-gray-600 dark:placeholder-gray-300 rounded-md border border-gray-300 focus:outline-none focus:border-blue-300 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600'
]) }} />

@endif