@error($name)

<input {{ $attributes->merge([
    'type' => 'text',
    'class' => 'w-full py-2 px-4 placeholder-gray-600 rounded-md border focus:outline-none focus:ring-2 focus:ring-opacity-75 border-red-300 focus:border-red-400 focus:ring-red-200'
]) }} />

@else

<input {{ $attributes->merge([
    'type' => 'text',
    'class' => 'w-full py-2 px-4 placeholder-gray-600 rounded-md border border-gray-300 focus:outline-none focus:border-blue-300 focus:ring-2 focus:ring-blue-200 focus:ring-opacity-50'
]) }} />

@endif