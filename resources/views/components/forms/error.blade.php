@error($name)

<div {{ $attributes->merge(['class'=> 'text-red-600 font-semibold mt-2 text-sm dark:text-red-400']) }}>
    {{ $message }}
</div>

@enderror