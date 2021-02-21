<?php

namespace App\Http\Livewire\Members;

use App\Models\Board;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Index extends Component
{
    use AuthorizesRequests;

    public Board $board;

    public function mount()
    {
        $this->authorize('view', $this->board);
    }

    public function render()
    {
        return view('members.index');
    }
}
