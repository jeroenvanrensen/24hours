<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Arr;

uses()->beforeEach(fn () => $this->withoutExceptionHandling());

it('has a role', function () {
    $role = Arr::random(['viewer', 'member']);
    $membership = Membership::factory()->create(['role' => $role]);
    expect($membership->role)->toBe($role);
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $membership = Membership::factory()->create(['user_id' => $user->id]);

    expect($membership->user_id)->toBe($user->id);
    expect($membership->user)->toBeInstanceOf(User::class);
    expect($membership->user->id)->toBe($user->id);
});

it('belongs to a board', function () {
    $board = Board::factory()->create();
    $membership = Membership::factory()->create(['board_id' => $board->id]);

    expect($membership->board_id)->toBe($board->id);
    expect($membership->board)->toBeInstanceOf(Board::class);
    expect($membership->board->id)->toBe($board->id);
});
