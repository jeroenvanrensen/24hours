<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class Search extends Component
{
    public $query;

    protected $results = [];

    public function render()
    {
        return view('search', [
            'results' => $this->results
        ]);
    }

    public function updated()
    {
        if ($this->query == '') {
            return $this->reset('results');
        }

        $this->results = $this->getItems()
            ->flatten()
            ->filter(fn ($item) => $this->filterItem($item))
            ->sortByDesc('updated_at');
    }

    protected function getItems(): Collection
    {
        return collect([
            auth()->user()->visibleBoards(),
            auth()->user()->visibleLinks(),
            auth()->user()->visibleNotes()
        ]);
    }

    protected function filterItem($item): bool
    {
        foreach (['name', 'title', 'body'] as $field) {
            if (stristr($item->$field, $this->query)) {
                return true;
            }
        }

        return false;
    }
}
