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
        return view('boards.edit')
            ->layout('layouts.app', [
                'defaultNavbar' => false,
                'backLink' => route('boards.show', $this->board),
                'backText' => $this->board->name
            ]);
    }

    public function update()
    {
        $this->validate();

        $this->board->save();

        return redirect()->route('boards.show', $this->board);
    }

    public function destroy()
    {
        $this->board->links()->delete();
        $this->board->notes()->delete();

        $this->board->delete();

        return redirect()->route('boards.index');
    }
}
