<?php

namespace App\Observers;

use App\Mail\InvitationMail;
use App\Models\Invitation;
use Illuminate\Support\Facades\Mail;

class InvitationObserver
{
    public function created(Invitation $invitation): void
    {
        Mail::to($invitation->email)->queue(new InvitationMail($invitation));
    }
}
