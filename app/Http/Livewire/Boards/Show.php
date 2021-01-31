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

    protected $listeners = [
        'createdLink' => 'hideModal'
    ];

    public function mount()
    {
        $this->authorize('view', $this->board);
    }

    public function render()
    {
        $this->board->forceFill(['updated_at' => now()])->save();

        return view('boards.show');
    }

    public function hideModal()
    {
        $this->emit('hideModal');
    }

    public function createNote()
    {
        $note = Note::create([
            'board_id' => $this->board->id,
            'title' => 'No Title',
            'body' => null
        ]);

        return redirect()->route('notes.edit', $note);
    }
}
