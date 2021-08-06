<?php

use App\Models\Board;
use App\Models\Link;
use App\Models\Membership;
use App\Models\User;

beforeEach(fn () => $this->withoutExceptionHandling());

test('the board owner can visit a link', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $link = Link::factory()->for($board)->create();

    $this->get(route('links.show', $link))->assertRedirect($link->url);
});

test('members can visit a link', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    $link = Link::factory()->for($board)->create();

    $this->get(route('links.show', $link))->assertRedirect($link->url);
});

test('viewers can visit a link', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();
    $link = Link::factory()->for($board)->create();

    $this->get(route('links.show', $link))->assertRedirect($link->url);
});

test('guests cannot visit a link', function () {
    $this->withExceptionHandling();
    $link = Link::factory()->create();
    $this->get(route('links.show', $link))->assertRedirect(route('login'));
});

test('users cannot visit a link of a board where they are not member', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create(); // other user
    $link = Link::factory()->for($board)->create();

    $this->get(route('links.show', $link))->assertStatus(403);
});

test('the updated_at timestamp is updated after visiting a link', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $link = Link::factory()->for($board)->create(['updated_at' => now()->subWeek()]);

    // Assert that the link was last updated longer than 60 seconds ago
    expect($link->fresh()->updated_at->diffInSeconds())->toBeGreaterThan(60);

    $this->get(route('links.show', $link))->assertRedirect($link->url);

    // Assert that the link was last updated between now and 60 seconds ago
    expect($link->fresh()->updated_at->diffInSeconds())->toBeLessThan(60);
});

test('a user can visit links when the board is archived', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();
    $link = Link::factory()->for($board)->create();

    $this->get(route('links.show', $link))->assertRedirect($link->url);
});
