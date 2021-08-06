<?php

use App\Http\Livewire\Boards\Show;
use App\Mail\BoardArchivedMail;
use App\Mail\BoardUnarchivedMail;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('the board owner can archive the board', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    expect($board->fresh()->archived)->toBeFalse();

    Livewire::test(Show::class, ['board' => $board])
        ->call('archive')
        ->assertRedirect(route('boards.show', $board));

    expect($board->fresh()->archived)->toBeTrue();
});

test('board members cannot archive the board', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();

    Livewire::test(Show::class, ['board' => $board])->call('archive')->assertStatus(403);
    expect($board->fresh()->archived)->toBeFalse();
});

test('board viewers cannot archive the board', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    Livewire::test(Show::class, ['board' => $board])->call('archive')->assertStatus(403);
    expect($board->fresh()->archived)->toBeFalse();
});

test('all members get notified when the board is archived', function () {
    Mail::fake();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $member = User::factory()->create();
    Membership::factory()->for($member)->for($board)->create();

    Mail::assertNothingQueued();
    Livewire::test(Show::class, ['board' => $board])->call('archive');
    Mail::assertQueued(BoardArchivedMail::class, fn ($mail) => $mail->hasTo($member->email));
});

test('the board owner does not get notified when the board is archived', function () {
    Mail::fake();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    Livewire::test(Show::class, ['board' => $board])->call('archive');
    Mail::assertNothingQueued();
});

test('the board owner can unarchive a board', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();
    expect($board->fresh()->archived)->toBeTrue();

    Livewire::test(Show::class, ['board' => $board])
        ->call('unarchive')
        ->assertRedirect(route('boards.show', $board));

    expect($board->fresh()->archived)->toBeFalse();
});

test('board members cannot unarchive a board', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->archived()->create();
    Membership::factory()->for($user)->for($board)->member()->create();

    Livewire::test(Show::class, ['board' => $board])->call('unarchive')->assertStatus(403);
    expect($board->fresh()->archived)->toBeTrue();
});

test('board viewers cannot unarchive a board', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->archived()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    Livewire::test(Show::class, ['board' => $board])->call('unarchive')->assertStatus(403);
    expect($board->fresh()->archived)->toBeTrue();
});

test('all members get notified when the board is unarchived', function () {
    Mail::fake();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create(['archived' => true]);
    $member = User::factory()->create();
    Membership::factory()->for($member)->for($board)->member()->create();

    Mail::assertNothingQueued();
    Livewire::test(Show::class, ['board' => $board])->call('unarchive');
    Mail::assertQueued(BoardUnarchivedMail::class, fn ($mail) => $mail->hasTo($member->email));
});

test('the board owner does not get notified when the board is unarchived', function () {
    Mail::fake();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create(['archived' => true]);

    Livewire::test(Show::class, ['board' => $board])->call('unarchive');
    Mail::assertNothingQueued();
});

test('board viewers dont get notified when the board is unarchived', function () {
    Mail::fake();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create(['archived' => true]);
    $viewer = User::factory()->create();
    Membership::factory()->for($viewer)->for($board)->viewer()->create();

    Livewire::test(Show::class, ['board' => $board])->call('unarchive');
    Mail::assertNothingQueued();
});
