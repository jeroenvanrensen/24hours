<?php

use App\Http\Livewire\Boards\Edit;
use App\Mail\BoardDeletedMail;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\Link;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

uses()->beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can delete a board', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    expect($board->exists())->toBeTrue();

    Livewire::test(Edit::class, ['board' => $board])
        ->call('destroy')
        ->assertRedirect(route('boards.index'));

    expect($board->exists())->toBeFalse();
});

test('deleting a board deletes all its links too', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $link = Link::factory()->for($board)->create();
    expect($link->exists())->toBeTrue();

    Livewire::test(Edit::class, ['board' => $board])->call('destroy');
    expect($link->exists())->toBeFalse();
});

test('deleting a board deletes all its notes too', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();
    expect($note->exists())->toBeTrue();

    Livewire::test(Edit::class, ['board' => $board])->call('destroy');
    expect($note->exists())->toBeFalse();
});

test('deleting a board deletes all its memberships too', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $membership = Membership::factory()->for($board)->create();
    expect($membership->exists())->toBeTrue();

    Livewire::test(Edit::class, ['board' => $board])->call('destroy');
    expect($membership->exists())->toBeFalse();
});

test('deleting a board deletes all its invitations too', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $invitation = Invitation::factory()->for($board)->create();
    expect($invitation->exists())->toBeTrue();

    Livewire::test(Edit::class, ['board' => $board])->call('destroy');
    expect($invitation->exists())->toBeFalse();
});

test('every member will get an email when a board is deleted', function () {
    Mail::fake();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $member = User::factory()->create();
    Membership::factory()->for($board)->for($member)->create();

    Mail::assertNothingQueued();
    Livewire::test(Edit::class, ['board' => $board])->call('destroy');
    Mail::assertQueued(BoardDeletedMail::class, fn ($mail) => $mail->hasTo($member->email));
});

test('archived boards can be deleted too', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();
    expect($board->exists())->toBeTrue();

    Livewire::test(Edit::class, ['board' => $board])
        ->call('destroy')
        ->assertRedirect(route('boards.index'));

    expect($board->exists())->toBeFalse();
});
