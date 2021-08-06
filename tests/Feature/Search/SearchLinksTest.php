<?php

use App\Http\Livewire\Search\Search;
use App\Models\Board;
use App\Models\Link;
use App\Models\Membership;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can search their links', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $firstLink = Link::factory()->for($board)->create(['title' => 'First Link']);
    $secondLink = Link::factory()->for($board)->create(['title' => 'Second Link']);

    Livewire::test(Search::class)
        ->assertDontSee($firstLink->title)
        ->assertDontSee($secondLink->title)
        ->set('query', 'First')
        ->assertSee($firstLink->title)
        ->assertDontSee($secondLink->title);
});

test('a user cannot see a link they dont own', function () {
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create(); // other user

    $link = Link::factory()->for($board)->create();
    Livewire::test(Search::class)->set('query', $link->title)->assertDontSee($link->title);
});

test('a user can search links when they are a member', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create(['name' => 'First Board']);
    Membership::factory()->for($user)->for($board)->create();

    $link = Link::factory()->for($board)->create(['title' => 'First link']);
    Livewire::test(Search::class)->set('query', 'First')->assertSee($link->title);
});

test('the links are sorted by date', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $firstLink = Link::factory()->for($board)->create(['title' => 'First Link', 'updated_at' => now()->subWeek()]);
    $secondLink = Link::factory()->for($board)->create(['title' => 'Second Link', 'updated_at' => now()]);

    Livewire::test(Search::class)
        ->set('query', 'Link')
        ->assertSeeInOrder([$secondLink->title, $firstLink->title]);
});

test('a user can search archived links', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();

    $link = Link::factory()->for($board)->create(['title' => 'First Link']);
    Livewire::test(Search::class)->set('query', 'First')->assertSee($link->title);
});
