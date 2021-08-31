<?php

use App\Http\Livewire\Boards\Index;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Livewire\Livewire;

test('a user can visit the boards index page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('boards.index'))
        ->assertStatus(200)
        ->assertSeeLivewire('boards.index')
        ->assertSeeLivewire('boards.create');
});

test('guests cannot visit the board index page', function () {
    $this->withExceptionHandling();
    $this->get(route('boards.index'))->assertRedirect(route('login'));
});

test('a user can see all their boards', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    Livewire::test(Index::class)->assertSee($board->name);
});

test('a user cannot see boards they dont own', function () {
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create(); // other user
    Livewire::test(Index::class)->assertDontSee($board->name);
});

test('users can see all boards where they are member', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    Livewire::test(Index::class)->assertSee($board->name);
});

test('users can see all boards where they are viewer', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();
    Livewire::test(Index::class)->assertSee($board->name);
});

test('the boards are ordered by date', function () {
    $this->actingAs($user = User::factory()->create());

    $firstBoard = Board::factory()->for($user)->create(['updated_at' => now()->subWeek()]);
    $lastBoard = Board::factory()->for($user)->create(['updated_at' => now()]);

    Livewire::test(Index::class)->assertSeeInOrder([$lastBoard->name, $firstBoard->name]);
});

test('archived boards are below non archived boards', function () {
    $this->actingAs($user = User::factory()->create());

    $archivedBoard = Board::factory()->for($user)->archived()->create(['updated_at' => now()]);
    $regularBoard = Board::factory()->for($user)->create(['updated_at' => now()->subWeek()]);

    Livewire::test(Index::class)->assertSeeInOrder([$regularBoard->name, $archivedBoard->name]);
});
