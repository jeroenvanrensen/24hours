<?php

use App\Http\Livewire\Boards\Show;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Livewire\Livewire;

test('a user can visit the single board page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $this->get(route('boards.show', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('boards.show')
        ->assertSeeLivewire('links.create')
        ->assertSeeLivewire('items.index');
});

test('guests cannot visit a single board page', function () {
    $this->withExceptionHandling();
    $board = Board::factory()->create();
    $this->get(route('boards.show', $board))->assertRedirect(route('login'));
});

test('members can visit a single board page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();

    $this->get(route('boards.show', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('boards.show')
        ->assertSeeLivewire('links.create')
        ->assertSeeLivewire('items.index');
});

test('viewers can visit a single board page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    $this->get(route('boards.show', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('boards.show')
        ->assertDontSeeLivewire('links.create')
        ->assertSeeLivewire('items.index');
});

test('other users cannot visit a single board page', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create(); // other user
    $this->get(route('boards.show', $board))->assertStatus(403);
});

test('a user can see the board name at the board page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    Livewire::test(Show::class, ['board' => $board])->assertSee($board->name);
});

test('the updated at timestamp is updated after visiting the page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create(['updated_at' => now()->subWeek()]);

    // Assert that the board was last updated longer than 60 seconds ago
    expect($board->fresh()->updated_at->diffInSeconds())->toBeGreaterThan(60);

    Livewire::test(Show::class, ['board' => $board])->assertSee($board->name);

    // Assert that the board was last updated between now and 60 seconds ago
    expect($board->fresh()->updated_at->diffInSeconds())->toBeLessThan(60);
});
