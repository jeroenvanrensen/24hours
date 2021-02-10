<div>
    <x-heading>Search</x-heading>

    <x-forms.group>
        <x-forms.input type="text" name="query" id="query" wire:model="query" placeholder="Search anything..." autofocus />
    </x-forms.group>
    
    @foreach($results as $result)
        @include('search.types.' . strtolower(class_basename($result)))
    @endforeach
</div>
