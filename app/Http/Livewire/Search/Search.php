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
        if($this->query == '') {
            return $this->reset('results');
        }

        $this->results = auth()->user()->boards()
            ->where('name', 'like', '%' . $this->query . '%')
            ->orderBy('updated_at', 'desc')
            ->get();
    }
}
