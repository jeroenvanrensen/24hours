<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;

    public $image;

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'image' => ['required', 'image', 'max:1024']
    ];

    protected $listeners = [
        'create'
    ];

    public function render()
    {
        return view('boards.create');
    }

    public function create()
    {
        $attributes = $this->validate();

        $path = $this->image->store('public');

        $board = Board::create([
            'user_id' => auth()->id(),
            'image' => str_replace('public/', 'storage/', $path)
        ] + $attributes);

        session()->flash('flash.success', 'The board was created!');

        return redirect()->route('boards.show', $board);
    }
}
