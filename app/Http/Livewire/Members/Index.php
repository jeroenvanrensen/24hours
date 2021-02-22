<?php

namespace App\Http\Livewire\Members;

use App\Models\Board;
use App\Models\Membership;
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
        return view('members.index')
            ->layout('layouts.app', [
                'defaultNavbar' => false,
                'backLink' => route('boards.show', $this->board),
                'backText' => $this->board->name
            ]);
    }

    public function leave()
    {
        $this->authorize('leave', $this->board);

        Membership::query()
            ->where('user_id', auth()->id())
            ->where('board_id', $this->board->id)
            ->delete();

        return redirect()->route('boards.index');
    }
}
