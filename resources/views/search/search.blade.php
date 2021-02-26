<div>
    <x-heading>Search</x-heading>

    <x-forms.group>
        <x-forms.input type="text" name="query" id="query" wire:model="query" placeholder="Search anything..." autofocus />
    </x-forms.group>
    
    @forelse($results as $result)
        @include('search.types.' . strtolower(class_basename($result)))
    @empty
        @if(strlen($query) > 0)
            <p>No results found.</p>
        @endif
    @endforelse
</div>
