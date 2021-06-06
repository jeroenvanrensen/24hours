<?php

namespace App\Mail;

use App\Models\Board;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BoardUnarchivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Board $board;

    public User $receiver;

    public function __construct(Board $board, User $receiver)
    {
        $this->board = $board;
        $this->receiver = $receiver;
    }

    public function build()
    {
        return $this->markdown('emails.board-unarchived')
            ->subject("{$this->board->name} was unarchived - 24Hours");
    }
}
