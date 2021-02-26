<?php

namespace App\Http\Livewire\Search;

use Livewire\Component;

class Search extends Component
{
    public $query;

    public $results = [];

    public function render()
    {
        return view('search.search');
    }

    public function updated()
    {
        if ($this->query == '') {
            return $this->reset('results');
        }

        $this->results = $this->getItems()
            ->flatten()
            ->filter(fn($item) => $this->filterItem($item))
            ->sortByDesc('updated_at');
    }

    protected function getItems()
    {
        return collect([
            auth()->user()->visibleBoards(),
            auth()->user()->visibleLinks(),
            auth()->user()->visibleNotes()
        ]);
    }

    protected function filterItem($item)
    {
        foreach(['name', 'title', 'body'] as $field) {
            if(stristr($item->$field, $this->query)) {
                return true;
            }
        }

        return false;
    }
}
