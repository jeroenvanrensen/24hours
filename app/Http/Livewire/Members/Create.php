<?php

namespace App\Http\Livewire\Members;

use App\Models\Board;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Create extends Component
{
    use AuthorizesRequests;

    public $email;

    public $role = 'member';

    public Board $board;

    protected $rules = [
        'email' => ['required', 'email', 'max:255'],
        'role' => ['required', 'in:member,viewer', 'max:255'],
    ];

    protected $messages = [
        'email.exists' => 'This user cannot be found.',
    ];

    protected $listeners = [
        'invite',
    ];

    public function render()
    {
        return view('members.create');
    }

    public function invite()
    {
        $this->authorize('edit', $this->board);

        if ($this->invitationExists()) {
            return $this->addError('email', 'This user is already invited.');
        }

        if ($this->membershipExists()) {
            return $this->addError('email', 'This user is already a member.');
        }

        Invitation::create(['board_id' => $this->board->id] + $this->validate());

        session()->flash('success', "{$this->email} has been invited to this board!");
        $this->reset(['email', 'role']);
    }

    protected function invitationExists(): bool
    {
        return $this->board->invitations()->where('email', $this->email)->exists();
    }

    protected function membershipExists(): bool
    {
        $userId = User::where('email', $this->email)->first()?->id;

        return $this->board->memberships()->where('user_id', $userId)->exists();
    }
}
