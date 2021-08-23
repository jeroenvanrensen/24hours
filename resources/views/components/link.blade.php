@props(['button' => false])

<{{ $button ? 'button' : 'a' }}
    {{
    $attributes->merge([
    'class' => 'font-medium text-indigo-600 outline-none  hover:text-indigo-700 focus:text-indigo-800 focus:outline-none dark:text-gray-200 dark:underline dark:hover:text-white'])
    }}
>
    {{ $slot }}
</{{ $button ? 'button' : 'a' }}>
