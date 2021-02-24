<?php

namespace App\Mail;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MemberRemovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Membership $membership;

    public User $receiver;

    public function __construct(Membership $membership, User $receiver)
    {
        $this->membership = $membership;
        $this->receiver = $receiver;
    }

    public function build()
    {
        return $this->markdown('emails.member-removed')
            ->subject($this->membership->user->first_name . ' is removed from ' . $this->membership->board->name . ' - 24Hours');
    }
}
