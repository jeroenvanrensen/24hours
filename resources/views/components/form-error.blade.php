@error($name)

<div {{ $attributes->merge(['class'=> 'text-red-600 font-medium mt-2 text-sm dark:text-red-400 dark:font-normal']) }}>
    {{ $message }}
</div>

@enderror