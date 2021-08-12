@props(['name'])

<input {{ $attributes->merge([
    'type' => in_array($name, ['email', 'password']) ? $name : 'text',
    'name' => $name,
    'id' => $name
    ]) }}
    class="block w-full px-4 py-2 rounded-md shadow-sm  focus:ring-1 placeholder-gray-400 focus:ring-indigo-500 focus:border-indigo-500 {{ $errors->has($name) ? 'border border-red-500' : 'border border-gray-300 ' }}"
/>
