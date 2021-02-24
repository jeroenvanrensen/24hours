<?php

namespace App\Mail;

use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Membership $membership;

    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }

    public function build()
    {
        return $this->markdown('emails.membership-updated')
            ->subject('Your membership has been updated - 24Hours');
    }
}
