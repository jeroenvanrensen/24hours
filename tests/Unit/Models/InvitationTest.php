<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Invitation;
use Illuminate\Support\Arr;
use function Pest\Faker\faker;

it('has an email', function () {
    $email = faker()->email();
    $invitation = Invitation::factory()->create(['email' => $email]);
    expect($invitation->email)->toBe($email);
});

it('has a role', function () {
    $role = Arr::random(['viewer', 'member']);
    $invitation = Invitation::factory()->create(['role' => $role]);
    expect($invitation->role)->toBe($role);
});

it('belongs to a board', function () {
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->create(['board_id' => $board->id]);

    expect($invitation->board_id)->toBe($board->id);
    expect($invitation->board)->toBeInstanceOf(Board::class);
    expect($invitation->board->id)->toBe($board->id);
});
