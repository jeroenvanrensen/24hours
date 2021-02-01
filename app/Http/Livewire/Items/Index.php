<?php

namespace App\Http\Livewire\Items;

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
        return view('items.index', [
            'items' => $this->getItems(),
            'showButton' => $this->showLoadMoreButton()
        ]);
    }

    protected function getItems()
    {
        return $this->board->items
            ->sortByDesc('updated_at')
            ->take($this->numberToShow);
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
