<?php

use App\Http\Livewire\Items\Index;
use App\Http\Livewire\Notes\Edit;
use App\Models\Board;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('the board owner can delete a note from the edit page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();
    expect($note->exists())->toBeTrue();

    Livewire::test(Edit::class, ['note' => $note])
        ->call('destroy')
        ->assertRedirect(route('boards.show', $board));

    expect($note->exists())->toBeFalse();
});

test('members can delete notes from the edit page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    $note = Note::factory()->for($board)->create();

    expect($note->exists())->toBeTrue();

    Livewire::test(Edit::class, ['note' => $note])
        ->call('destroy')
        ->assertRedirect(route('boards.show', $board));

    expect($note->exists())->toBeFalse();
});

test('viewers can delete notes from the edit page', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();
    $note = Note::factory()->for($board)->create();

    Livewire::test(Edit::class, ['note' => $note])->call('destroy')->assertStatus(403);
    expect($note->exists())->toBeTrue();
});

test('a user cannot delete a note from the edit page when the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();
    $note = Note::factory()->for($board)->create();

    Livewire::test(Edit::class, ['note' => $note])->call('destroy')->assertStatus(403);
    expect($note->exists())->toBeTrue();
});

test('the board owner can delete a note from the board page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();

    expect($note->exists())->toBeTrue();

    Livewire::test(Index::class, ['board' => $board])
        ->call('deleteNote', $note)
        ->assertRedirect(route('boards.show', $board));

    expect($note->exists())->toBeFalse();
});

test('members can delete notes from the board page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    $note = Note::factory()->for($board)->create();

    expect($note->exists())->toBeTrue();

    Livewire::test(Index::class, ['board' => $board])
        ->call('deleteNote', $note)
        ->assertRedirect(route('boards.show', $board));

    expect($note->exists())->toBeFalse();
});

test('viewers can delete notes from the board page', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();
    $note = Note::factory()->for($board)->create();

    Livewire::test(Index::class, ['board' => $board])->call('deleteNote', $note)->assertStatus(403);
    expect($note->exists())->toBeTrue();
});

test('a user cannot delete notes from the board page when the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create([]);
    $note = Note::factory()->for($board)->create();

    Livewire::test(Index::class, ['board' => $board])->call('deleteNote', $note)->assertStatus(403);
    expect($note->exists())->toBeTrue();
});
