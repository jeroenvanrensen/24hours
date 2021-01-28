<?php

namespace App\Http\Livewire\Search;

use Livewire\Component;

class Search extends Component
{
    public $query;

    protected $results = [];

    public function render()
    {
        return view('search.search', [
            'results' => $this->results
        ]);
    }

    public function updated()
    {
        if ($this->query == '') {
            return $this->reset('results');
        }

        $this->results = collect([auth()->user()->boards, auth()->user()->links])
            ->flatten()
            ->filter(fn($item) => stristr($item->name, $this->query) || stristr($item->title, $this->query))
            ->sortByDesc('updated_at');
    }
}
