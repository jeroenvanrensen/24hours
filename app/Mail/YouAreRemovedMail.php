<?php

namespace App\Mail;

use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class YouAreRemovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Membership $membership;

    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }

    public function build()
    {
        return $this->markdown('emails.you-are-removed')
            ->subject('You are removed from ' . $this->membership->board->name . ' - 24Hours');
    }
}
