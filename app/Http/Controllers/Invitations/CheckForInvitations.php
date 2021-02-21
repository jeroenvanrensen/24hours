<?php

namespace App\Http\Controllers\Invitations;

use App\Models\Invitation;

class CheckForInvitations
{
    public function __invoke()
    {
        $invitation = Invitation::where('email', auth()->user()->email)->first();

        if($invitation) {
            return redirect()->route('invitations.show', $invitation);
        }

        return redirect()->route('boards.index');
    }
}
