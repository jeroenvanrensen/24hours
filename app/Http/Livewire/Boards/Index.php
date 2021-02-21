<?php

namespace App\Http\Livewire\Boards;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('boards.index', [
            'boards' => auth()->user()->visibleBoards()
        ]);
    }
}
