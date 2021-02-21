<?php

namespace App\Policies;

use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BoardPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Board $board): bool
    {
        return $this->hasPermission($user, $board, ['member', 'viewer']);
    }

    public function edit(User $user, Board $board): bool
    {
        return $this->hasPermission($user, $board, []);
    }

    public function visitLink(User $user, Board $board): bool
    {
        return $this->hasPermission($user, $board, []);
    }

    public function editNote(User $user, Board $board): bool
    {
        return $this->hasPermission($user, $board, []);
    }

    protected function hasPermission(User $user, Board $board, array $allowedRoles): bool
    {
        if($user->id == $board->user->id) {
            return true;
        }

        if(!$membership = Membership::where('user_id', $user->id)->where('board_id', $board->id)->first()) {
            return false;
        }

        return in_array($membership->role, $allowedRoles);
    }
}
