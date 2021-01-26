<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Show extends Component
{
    use AuthorizesRequests;

    public Board $board;

    public function mount()
    {
        $this->authorize('view', $this->board);
    }

    public function render()
    {
        return view('boards.show');
    }
}
