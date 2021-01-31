<button {{ $attributes->merge([
    'class' => 'fixed bottom-48 right-12 p-3 bg-gray-400 hover:bg-gray-500 rounded-full transition focus:outline-none focus:bg-gray-600 text-white'
]) }}>
    {{ $slot }}
</button>