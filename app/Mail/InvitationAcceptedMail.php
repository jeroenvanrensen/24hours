<?php

namespace App\Mail;

use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Membership $membership;

    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }

    public function build()
    {
        return $this->markdown('emails.invitation-accepted')
            ->subject($this->membership->user->name . ' accepted your invitation - 24Hours');
    }
}
