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
        $this->validate();

        Board::create([
            'user_id' => auth()->id(),
            'name' => $this->name
        ]);

        return redirect()->route('dashboard');
    }
}
