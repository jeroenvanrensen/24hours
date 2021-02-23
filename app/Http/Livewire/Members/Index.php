<?php

namespace App\Http\Livewire\Members;

use App\Mail\BoardLeftMail;
use App\Models\Board;
use App\Models\Membership;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
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

        $membership = Membership::query()
            ->where('user_id', auth()->id())
            ->where('board_id', $this->board->id)
            ->first();

        Mail::to($this->board->user->email)->queue(new BoardLeftMail($membership, $this->board->user));

        foreach($this->board->fresh()->memberships as $receiver) {
            if($receiver->id == $membership->id) {
                continue;
            }

            Mail::to($receiver->user->email)->queue(new BoardLeftMail($membership, $receiver->user));
        }

        $membership->delete();

        return redirect()->route('boards.index');
    }
}
