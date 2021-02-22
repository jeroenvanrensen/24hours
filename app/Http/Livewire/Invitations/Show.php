<?php

namespace App\Http\Livewire\Invitations;

use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public Invitation $invitation;

    public function mount()
    {
        if(!auth()->check()) {
            return $this->redirectGuest();
        }

        if(auth()->user()->email != $this->invitation->email) {
            abort(403);
        }
    }

    protected function redirectGuest()
    {
        if(User::where('email', $this->invitation->email)->exists()) {
            return redirect()->route('login');
        }

        return redirect()->route('register');
    }

    public function render()
    {
        return view('invitations.show')
            ->layout('layouts.app', [
                'defaultNavbar' => false,
                'backLink' => route('boards.index'),
                'backText' => 'Go Home'
            ]);
    }

    public function accept()
    {
        Membership::create([
            'board_id' => $this->invitation->board->id,
            'user_id' => auth()->id(),
            'role' => $this->invitation->role
        ]);

        $this->invitation->delete();

        return redirect()->route('boards.show', $this->invitation->board);
    }

    public function deny()
    {
        $this->invitation->delete();
        
        return redirect()->route('invitations.check');
    }
}
