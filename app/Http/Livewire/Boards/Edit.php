<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    public Board $board;

    protected $rules = [
        'board.name' => ['required', 'string', 'max:255']
    ];

    public function mount()
    {
        $this->authorize('edit', $this->board);
    }

    public function render()
    {
        return view('boards.edit');
    }

    public function update()
    {
        $this->validate();

        $this->board->save();

        return redirect()->route('boards.show', $this->board);
    }
}
