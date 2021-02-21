<?php

namespace App\Mail\Members;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public Invitation $invitation;

    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    public function build()
    {
        return $this->markdown('emails.members.invitation', [
            'username' => User::where('email', $this->invitation->email)->first()->name ?? $this->invitation->email
        ])->subject('You have been invited to ' . $this->invitation->board->name . ' - 24Hours');
    }
}
