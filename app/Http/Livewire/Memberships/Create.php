<?php

namespace App\Http\Livewire\Memberships;

use App\Mail\Members\InvitationMail;
use App\Models\Board;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Create extends Component
{
    public $email;
    public $role;

    public Board $board;

    protected $rules = [
        'email' => ['required', 'exists:users', 'max:255'],
        'role' => ['required', 'in:member,viewer', 'max:255']
    ];

    public function render()
    {
        return view('memberships.create');
    }

    public function invite()
    {
        $this->validate();

        $invitation = Invitation::create([
            'board_id' => $this->board->id,
            'email' => $this->email,
            'role' => $this->role
        ]);

        Mail::to($this->email)->queue(new InvitationMail($invitation));
    }
}
