<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Board $board): bool
    {
        return $this->isOwner($user, $board);
    }

    public function visitLink(User $user, Board $board): bool
    {
        return $this->isOwner($user, $board);
    }

    public function editNote(User $user, Board $board): bool
    {
        return $this->isOwner($user, $board);
    }

    protected function isOwner(User $user, Board $board): bool
    {
        return $user->id == $board->user->id;
    }
}
