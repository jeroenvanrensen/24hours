<?php

use App\Http\Livewire\Items\Index;
use App\Models\Board;
use App\Models\Link;
use App\Models\Note;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can see all links', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $link = Link::factory()->for($board)->create();

    Livewire::test(Index::class, ['board' => $board])->assertSee($link->title);
});

test('the links are ordered by date', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $firstLink = Link::factory()->for($board)->create(['updated_at' => now()->subWeek()]);
    $lastLink = Link::factory()->for($board)->create(['updated_at' => now()]);

    Livewire::test(Index::class, ['board' => $board])->assertSeeInOrder([$lastLink->title, $firstLink->title]);
});

test('a user can see all notes', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();

    Livewire::test(Index::class, ['board' => $board])->assertSee($note->title);
});

test('the notes are ordered by date', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $firstNote = Note::factory()->for($board)->create(['updated_at' => now()->subWeek()]);
    $lastNote = Note::factory()->for($board)->create(['updated_at' => now()]);

    Livewire::test(Index::class, ['board' => $board])->assertSeeInOrder([$lastNote->title, $firstNote->title]);
});
