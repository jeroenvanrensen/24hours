<?php

namespace App\Http\Livewire\Members;

use App\Mail\MemberRemovedMail;
use App\Mail\YouAreRemovedMail;
use App\Models\Board;
use App\Models\Membership;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Delete extends Component
{
    use AuthorizesRequests;

    public Board $board;

    public Membership $membership;

    public function render()
    {
        return view('members.delete');
    }

    public function destroy()
    {
        $this->authorize('edit', $this->board);

        Mail::to($this->membership->user->email)->queue(new YouAreRemovedMail($this->membership));

        foreach($this->board->memberships as $membership) {
            if($membership->id == $this->membership->id) {
                continue;
            }
            
            Mail::to($membership->user->email)->queue(new MemberRemovedMail($this->membership, $membership->user));
        }

        $this->membership->delete();

        return redirect()->route('members.index', $this->board);
    }
}
