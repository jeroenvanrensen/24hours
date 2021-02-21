<?php

namespace App\Http\Controllers\Members;

use App\Models\Invitation;

class Store
{
    public function __invoke(Invitation $invitation)
    {
        if (auth()->user()->email != $invitation->email) {
            abort(403);
        }

        $invitation->delete();

        return redirect()->route('boards.show', $invitation->board);
    }
}
