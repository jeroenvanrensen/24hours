<?php

use App\Http\Livewire\Search\Search;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can search their boards', function () {
    $this->actingAs($user = User::factory()->create());

    $firstBoard = Board::factory()->for($user)->create(['name' => 'First Board']);
    $secondBoard = Board::factory()->for($user)->create(['name' => 'Second Board']);

    Livewire::test(Search::class)
        ->assertDontSee($firstBoard->name)
        ->assertDontSee($secondBoard->name)
        ->set('query', 'First')
        ->assertSee($firstBoard->name)
        ->assertDontSee($secondBoard->name);
});

test('a user cannot see boards they dont own', function () {
    $this->actingAs(User::factory()->create());

    $board = Board::factory()->create(['name' => 'First Board']); // other user
    Livewire::test(Search::class)->set('query', 'First')->assertDontSee($board->name);
});

test('a user can search boards when they are a member', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create(['name' => 'First Board']);
    Membership::factory()->for($user)->for($board)->create();

    Livewire::test(Search::class)->set('query', 'First')->assertSee($board->name);
});

test('the boards are sorted by date', function () {
    $this->actingAs($user = User::factory()->create());

    $firstBoard = Board::factory()->for($user)->create(['name' => 'First Board', 'updated_at' => now()->subWeek()]);
    $secondBoard = Board::factory()->for($user)->create(['name' => 'Second Board', 'updated_at' => now()]);

    Livewire::test(Search::class)->set('query', 'Board')->assertSeeInOrder([$secondBoard->name, $firstBoard->name]);
});

test('a user can search archived boards', function () {
    $this->actingAs($user = User::factory()->create());
    $firstBoard = Board::factory()->for($user)->archived()->create(['name' => 'First Board']);
    Livewire::test(Search::class)->set('query', 'First')->assertSee($firstBoard->name);
});
