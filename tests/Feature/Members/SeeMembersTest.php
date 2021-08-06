<?php

use App\Http\Livewire\Members\Index;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a board owner can visit the members page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $this->get(route('members.index', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('members.index')
        ->assertSeeLivewire('members.create');
});

test('members can visit the members page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();

    $this->get(route('members.index', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('members.index');
});

test('viewers can visit the members page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    $this->get(route('members.index', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('members.index');
});

test('guests cannot visit the members page', function () {
    $this->withExceptionHandling();
    $board = Board::factory()->create();
    $this->get(route('members.index', $board))->assertRedirect(route('login'));
});

test('non-members cannot visit the members page', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create();
    $this->get(route('members.index', $board))->assertStatus(403);
});

test('all members are visible on the index page', function () {
    $this->actingAs($user = User::factory()->create());
    $otherUser = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $member = Membership::factory()->for($otherUser)->for($board)->member()->create();

    Livewire::test(Index::class, ['board' => $board])
        ->assertSee($user->name)
        ->assertSee('Owner')
        ->assertSee($member->name)
        ->assertSee('Member');
});

test('a user can visit the members page when the board is archived', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();

    $this->get(route('members.index', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('members.index')
        ->assertSeeLivewire('members.create');
});
