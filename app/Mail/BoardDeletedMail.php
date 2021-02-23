<?php

namespace App\Mail;

use App\Models\Board;
use App\Models\Membership;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BoardDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Membership $membership;

    public Board $board;

    public function __construct(Membership $membership, Board $board)
    {
        $this->membership = $membership;
        $this->board = $board;
    }

    public function build()
    {
        return $this->markdown('emails.board-deleted')
            ->subject('Board ' . $this->board->name . ' deleted - 24Hours');
    }
}
