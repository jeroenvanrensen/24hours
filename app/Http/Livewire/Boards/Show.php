<?php

namespace App\Http\Livewire\Boards;

use App\Models\Board;
use App\Models\Note;
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
        $this->board->forceFill(['updated_at' => now()])->save();

        return view('boards.show');
    }

    public function createNote()
    {
        $this->authorize('manageItems', $this->board);

        $note = Note::create([
            'board_id' => $this->board->id,
            'title' => 'No Title',
            'body' => null
        ]);

        return redirect()->route('notes.edit', $note);
    }

    public function archive()
    {
        $this->authorize('edit', $this->board);

        $this->board->archive();
        
        session()->flash('flash.success', 'The board is archived!');

        return redirect()->route('boards.show', $this->board);
    }

    public function unarchive()
    {
        $this->authorize('edit', $this->board);
        
        $this->board->unarchive();
        
        session()->flash('flash.success', 'The board is unarchived!');

        return redirect()->route('boards.show', $this->board);
    }
}
