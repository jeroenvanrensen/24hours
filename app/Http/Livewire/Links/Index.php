<?php

namespace App\Http\Livewire\Links;

use App\Models\Board;
use Livewire\Component;

class Index extends Component
{
    public Board $board;

    protected $numberToShow = 50;

    protected $listeners = [
        'createdLink' => 'render'
    ];

    public function render()
    {
        return view('links.index', [
            'links' => $this->getLinks(),
            'showButton' => $this->showLoadMoreButton()
        ]);
    }

    protected function getLinks()
    {
        return $this->board->links()
            ->orderBy('updated_at', 'desc')
            ->take($this->numberToShow)
            ->get();
    }

    public function loadMore()
    {
        $this->numberToShow = $this->numberToShow + 50;
    }

    protected function showLoadMoreButton()
    {
        if($this->board->links()->count() <= $this->numberToShow) {
            return false;
        }

        return true;
    }
}
