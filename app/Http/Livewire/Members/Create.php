<?php

namespace App\Http\Livewire\Members;

use App\Mail\Members\InvitationMail;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    public $email;
    public $role = 'member';

    public Board $board;

    protected $rules = [
        'email' => ['required', 'email', 'max:255'],
        'role' => ['required', 'in:member,viewer', 'max:255']
    ];

    protected $messages = [
        'email.exists' => 'This user cannot be found.'
    ];

    public function render()
    {
        return view('members.create');
    }

    public function invite()
    {
        $this->authorize('edit', $this->board);

        $this->validate();

        if($this->invitationExists()) {
            return $this->addError('email', 'This user is already invited.');
        }

        if($this->membershipExists()) {
            return $this->addError('email', 'This user is already a member.');
        }

        $invitation = Invitation::create([
            'board_id' => $this->board->id,
            'email' => $this->email,
            'role' => $this->role
        ]);

        Mail::to($this->email)->queue(new InvitationMail($invitation));

        session()->flash('success', $this->email . ' has been invited to this board!');

        $this->reset(['email', 'role']);
    }

    protected function invitationExists()
    {
        return Invitation::query()
            ->where('board_id', $this->board->id)
            ->where('email', $this->email)
            ->first();
    }

    protected function membershipExists()
    {
        return Membership::query()
            ->where('board_id', $this->board->id)
            ->where('user_id', User::where('email', $this->email)->first()->id ?? null)
            ->first();
    }
}
