@error($name)

<div {{ $attributes->merge(['class'=> 'text-red-600 font-semibold mt-2 text-sm']) }}>
    {{ $message }}
</div>

@enderror