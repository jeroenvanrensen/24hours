<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use AuthorizesRequests;

    use WithFileUploads;

    public $image;

    public Board $board;

    protected $rules = [
        'image' => ['nullable', 'file', 'image', 'max:1024'],
        'board.name' => ['required', 'string', 'max:255'],
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

        if ($this->image) {
            $this->board->image = str_replace('public/', 'storage/', $this->image->store('public'));
        }

        $this->board->save();

        session()->flash('flash.success', 'The board was saved!');

        return redirect()->route('boards.show', $this->board);
    }

    public function destroy()
    {
        $this->board->delete();

        session()->flash('flash.success', 'The board was deleted!');

        return redirect()->route('boards.index');
    }
}
