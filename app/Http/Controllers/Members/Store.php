<?php

namespace App\Http\Controllers\Members;

use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;

class Store
{
    public function __invoke(Invitation $invitation)
    {
        if (auth()->user()->email != $invitation->email) {
            abort(403);
        }

        Membership::create([
            'board_id' => $invitation->board->id,
            'user_id' => User::where('email', $invitation->email)->firstOrFail()->id,
            'role' => $invitation->role
        ]);

        $invitation->delete();

        return redirect()->route('boards.show', $invitation->board);
    }
}
