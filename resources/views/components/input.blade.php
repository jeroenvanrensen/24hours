@props(['name'])

<input {{ $attributes->merge([
    'type' => in_array($name, ['email', 'password']) ? $name : 'text',
    'name' => $name,
    'id' => $name
    ]) }}
    class="block w-full px-4 py-2 rounded-md shadow-sm dark:bg-gray-800 focus:ring-1 focus:outline-none placeholder-gray-400 dark:focus:ring-indigo-300 dark:focus:border-indigo-300 focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has($name) ? 'border dark:border-red-400 border-red-500' : 'border border-gray-300 ' }}"
/>
