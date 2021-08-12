<a
    {{
    $attributes->merge([
    'class' => 'font-medium text-indigo-600 outline-none  hover:text-indigo-700 focus:text-indigo-800'])
    }}
>
    {{ $slot }}
</a>
