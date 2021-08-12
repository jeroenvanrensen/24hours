<?php

use App\Http\Livewire\Search;
use App\Models\Board;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can search their notes', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $firstNote = Note::factory()->for($board)->create(['title' => 'First Note']);
    $secondNote = Note::factory()->for($board)->create(['title' => 'Second Note']);

    Livewire::test(Search::class)
        ->assertDontSee($firstNote->title)
        ->assertDontSee($secondNote->title)
        ->set('query', 'First')
        ->assertSee($firstNote->title)
        ->assertDontSee($secondNote->title);
});

test('a user can search their notes by body', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $firstNote = Note::factory()->for($board)->create(['body' => 'First Note']);
    $secondNote = Note::factory()->for($board)->create(['body' => 'Second Note']);

    Livewire::test(Search::class)
        ->assertDontSee($firstNote->title)
        ->assertDontSee($secondNote->title)
        ->set('query', 'First')
        ->assertSee($firstNote->title)
        ->assertDontSee($secondNote->title);
});

test('a user can search notes when they are a member', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create(['name' => 'First Board']);
    Membership::factory()->for($user)->for($board)->create();

    $note = Note::factory()->for($board)->create(['title' => 'First note']);
    Livewire::test(Search::class)->set('query', 'First')->assertSee($note->title);
});

test('a user cannot see a note they dont own', function () {
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create(); // other user

    $note = Note::factory()->for($board)->create();
    Livewire::test(Search::class)->set('query', $note->title)->assertDontSee($note->title);
});

test('the notes are sorted by date', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $firstNote = Note::factory()->for($board)->create(['title' => 'First Note', 'updated_at' => now()->subWeek()]);
    $secondNote = Note::factory()->for($board)->create(['title' => 'Second Note', 'updated_at' => now()]);

    Livewire::test(Search::class)
        ->set('query', 'Note')
        ->assertSeeInOrder([$secondNote->title, $firstNote->title]);
});

test('a user can search archived notes', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();

    $note = Note::factory()->for($board)->create(['title' => 'First Note']);
    Livewire::test(Search::class)->set('query', 'First')->assertSee($note->title);
});
