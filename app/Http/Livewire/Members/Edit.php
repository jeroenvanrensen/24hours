<?php

namespace App\Http\Livewire\Members;

use App\Mail\MembershipUpdatedMail;
use App\Models\Board;
use App\Models\Membership;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Edit extends Component
{
    use AuthorizesRequests;

    public Board $board;

    public Membership $membership;

    public $role;

    protected $rules = [
        'role' => ['required', 'string', 'in:viewer,member', 'max:255']
    ];

    public function mount()
    {
        $this->authorize('edit', $this->board);

        $this->role = $this->membership->role;
    }

    public function render()
    {
        return view('members.edit')
            ->layout('layouts.app', [
                'defaultNavbar' => false,
                'backLink' => route('members.index', $this->board),
                'backText' => 'Members overview'
            ]);
    }

    public function update()
    {
        $data = $this->validate();

        $roleChanged = $this->membership->role != $this->role;

        $this->membership->update($data);

        if ($roleChanged) {
            Mail::to($this->membership->user->email)->queue(new MembershipUpdatedMail($this->membership));
        }

        session()->flash('flash.success', 'The member\'s role was updated!');

        return redirect()->route('members.index', $this->board);
    }
}
