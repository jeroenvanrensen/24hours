<?php

use App\Models\Board;
use App\Models\Invitation;
use App\Models\Link;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;

it('has a name', function () {
    $name = $this->faker->word();
    $board = Board::factory()->create(['name' => $name]);
    expect($board->name)->toBe($name);
});

it('has an image', function () {
    $image = $this->faker->imageUrl();
    $board = Board::factory()->create(['image' => $image]);
    expect($board->image)->toBe($image);
});

it('can be archived', function () {
    $board = Board::factory()->create(['archived' => true]);
    expect($board->archived)->toBeTrue();

    $board = Board::factory()->create(['archived' => false]);
    expect($board->archived)->toBeFalse();
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $board = Board::factory()->create(['user_id' => $user->id]);

    expect($board->user_id)->toBe($user->id);
    expect($board->user)->toBeInstanceOf(User::class);
    expect($board->user->id)->toBe($user->id);
});

it('has many links', function () {
    $board = Board::factory()->create();
    $link = Link::factory()->for($board)->create();

    expect($board->links)->toHaveCount(1);
    expect($board->links->first())->toBeInstanceOf(Link::class);
    expect($board->links->first()->id)->toBe($link->id);
});

it('has many notes', function () {
    $board = Board::factory()->create();
    $note = Note::factory()->for($board)->create();

    expect($board->notes)->toHaveCount(1);
    expect($board->notes->first())->toBeInstanceOf(Note::class);
    expect($board->notes->first()->id)->toBe($note->id);
});

it('has many items', function () {
    $board = Board::factory()->create();
    $link = Link::factory()->for($board)->create();
    $note = Note::factory()->for($board)->create();

    expect($board->items)->toHaveCount(2);
    expect($board->items->first())->toBeInstanceOf(Note::class);
    expect($board->items->first()->id)->toBe($note->id);
    expect($board->items->last())->toBeInstanceOf(Link::class);
    expect($board->items->last()->id)->toBe($link->id);
});

it('has many invitations', function () {
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->for($board)->create();

    expect($board->invitations)->toHaveCount(1);
    expect($board->invitations->first())->toBeInstanceOf(Invitation::class);
    expect($board->invitations->first()->id)->toBe($invitation->id);
});

it('has many memberships', function () {
    $board = Board::factory()->create();
    $membership = Membership::factory()->for($board)->create();

    expect($board->memberships)->toHaveCount(1);
    expect($board->memberships->first())->toBeInstanceOf(Membership::class);
    expect($board->memberships->first()->id)->toBe($membership->id);
});

it('can be archived and archived', function () {
    $board = Board::factory()->create(['archived' => false]);
    expect($board->fresh()->archived)->toBeFalse();

    $board->archive();
    expect($board->fresh()->archived)->toBeTrue();

    $board->unarchive();
    expect($board->fresh()->archived)->toBeFalse();
});
