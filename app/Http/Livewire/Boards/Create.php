<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use Livewire\Component;

class Create extends Component
{
    public $name;

    protected $rules = [
        'name' => ['required', 'string', 'max:255']
    ];

    public function render()
    {
        return view('boards.create');
    }

    public function create()
    {
        $board = Board::create($this->validate() + [
            'user_id' => auth()->id()
        ]);

        session()->flash('flash.success', 'The board was created!');

        return redirect()->route('boards.show', $board);
    }
}
