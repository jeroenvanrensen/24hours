<?php

use App\Http\Livewire\Boards\Show;
use App\Models\Board;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Livewire\Livewire;

test('the board owner can create a new note', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    expect(Note::all())->toHaveCount(0);

    Livewire::test(Show::class, ['board' => $board])
        ->call('createNote')
        ->assertRedirect(route('notes.edit', Note::first()));

    expect(Note::all())->toHaveCount(1);
    tap(Note::first(), function ($note) use ($board) {
        expect($note->board_id)->toBe($board->id);
        expect($note->title)->toBe('No Title');
        expect($note->body)->toBeNull();
    });
});

test('members can create a new note', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    expect(Note::all())->toHaveCount(0);

    Livewire::test(Show::class, ['board' => $board])
        ->call('createNote')
        ->assertRedirect(route('notes.edit', Note::first()));

    expect(Note::all())->toHaveCount(1);
});

test('viewers can create a new note', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    Livewire::test(Show::class, ['board' => $board])->call('createNote')->assertStatus(403);
    expect(Note::all())->toHaveCount(0);
});

test('a user cannot create a new note when the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create(['archived' => true]);

    Livewire::test(Show::class, ['board' => $board])->call('createNote')->assertStatus(403);
    expect(Note::all())->toHaveCount(0);
});
