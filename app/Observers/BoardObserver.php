<?php

namespace App\Observers;

use App\Mail\BoardDeletedMail;
use App\Models\Board;
use App\Models\Membership;
use Illuminate\Support\Facades\Mail;

class BoardObserver
{
    /**
     * Handle the Board "deleting" event.
     */
    public function deleting(Board $board): void
    {
        $board->memberships->each(function (Membership $membership) use ($board) {
            Mail::to($membership->user)->queue(new BoardDeletedMail($membership, $board));
        });
    }

    /**
     * Handle the Board "deleted" event.
     */
    public function deleted(Board $board): void
    {
        $board->links->each->delete();
        $board->notes->each->delete();
        $board->memberships->each->delete();
        $board->invitations->each->delete();
    }
}
