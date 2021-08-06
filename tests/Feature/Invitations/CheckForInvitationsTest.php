<?php

use App\Models\Board;
use App\Models\Invitation;
use App\Models\User;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can visit the invitations page', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('invitations.check'))->assertRedirect(route('boards.index'));
});

test('guests cannot visit the invitations page', function () {
    $this->withExceptionHandling();
    $this->get(route('invitations.check'))->assertRedirect(route('login'));
});

test('a user gets redirected to an invitation is there are any', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    $this->get(route('invitations.check'))->assertRedirect(route('invitations.show', $invitation));
});

test('a user does not get redirected to an invitation if the board is archived', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create(['archived' => true]);
    Invitation::factory()->for($board)->create(['email' => $user->email]);

    $this->get(route('invitations.check'))->assertRedirect(route('boards.index'));
});
