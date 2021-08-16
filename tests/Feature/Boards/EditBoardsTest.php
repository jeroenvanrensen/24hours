<?php

use App\Http\Livewire\Boards\Edit;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function () {
    $this->withoutExceptionHandling();
    Storage::fake();
});

test('the board owner can visit the edit board page ', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $this->get(route('boards.edit', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('boards.edit');
});

test('guests cannot visit the edit board page', function () {
    $this->withExceptionHandling();
    $board = Board::factory()->create();
    $this->get(route('boards.edit', $board))->assertRedirect(route('login'));
});

test('members cannot visit the edit page', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    $this->get(route('boards.edit', $board))->assertStatus(403);
});

test('viewers cannot visit the edit page', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();
    $this->get(route('boards.edit', $board))->assertStatus(403);
});

test('other users cannot visit the edit board page', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create(); // other user
    $this->get(route('boards.edit', $board))->assertStatus(403);
});

test('the board owner can visit the edit page when the board is archived', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();

    $this->get(route('boards.edit', $board))
        ->assertStatus(200)
        ->assertSeeLivewire('boards.edit');
});

test('the board owner can edit a board', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    expect($board->name)->not()->toBe('New Board Name');

    Livewire::test(Edit::class, ['board' => $board])
        ->set('board.name', 'New Board Name')
        ->call('update')
        ->assertRedirect(route('boards.show', $board));

    $this->assertEquals('New Board Name', $board->fresh()->name);
});

it('requires a name', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    Livewire::test(Edit::class, ['board' => $board])
        ->set('board.name', null)
        ->call('update')
        ->assertHasErrors('board.name');
});

test('the board owner can update the image', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $initialImage = $board->image;
    $image = UploadedFile::fake()->image('cover.jpg');

    Livewire::test(Edit::class, ['board' => $board])
        ->set('board.name', $board->name)
        ->set('image', $image)
        ->call('update')
        ->assertHasNoErrors();

    expect($board->fresh()->image)->not()->toBe($initialImage);
});
