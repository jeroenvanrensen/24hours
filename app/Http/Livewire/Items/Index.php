<?php

namespace App\Http\Livewire\Items;

use App\Models\Board;
use App\Models\Link;
use App\Models\Note;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Index extends Component
{
    use AuthorizesRequests;

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

    public function deleteNote(Note $note)
    {
        $note->delete();

        return redirect()->route('boards.show', $this->board);
    }

    public function deleteLink(Link $link)
    {
        $this->authorize('manageItems', $this->board);

        $link->delete();

        return redirect()->route('boards.show', $this->board);
    }
}
