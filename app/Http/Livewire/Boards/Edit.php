<?php

namespace App\Http\Livewire\Boards;

use App\Mail\BoardDeletedMail;
use App\Models\Board;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
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

        session()->flash('flash.success', 'The board was saved!');

        return redirect()->route('boards.show', $this->board);
    }

    public function destroy()
    {
        foreach ($this->board->memberships as $membership) {
            Mail::to($membership->user->email)->queue(new BoardDeletedMail($membership, $this->board));
        }

        $this->board->links()->delete();
        $this->board->notes()->delete();
        $this->board->memberships()->delete();
        $this->board->invitations()->delete();

        $this->board->delete();

        session()->flash('flash.success', 'The board was deleted!');

        return redirect()->route('boards.index');
    }
}
