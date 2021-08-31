<?php

use App\Http\Livewire\Members\Index;
use App\Mail\BoardLeftMail;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

beforeEach(fn () => Mail::fake());

test('a board owner cannot leave a board', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    Livewire::test(Index::class, ['board' => $board])->call('leave')->assertStatus(403);
});

test('a member can leave a board', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    $membership = Membership::factory()->for($user)->for($board)->member()->create();

    expect($membership->exists())->toBeTrue();
    Livewire::test(Index::class, ['board' => $board])->call('leave')->assertRedirect(route('boards.index'));
    expect($membership->exists())->toBeFalse();
});

test('a viewer can leave a board', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    $membership = Membership::factory()->for($user)->for($board)->viewer()->create();

    expect($membership->exists())->toBeTrue();
    Livewire::test(Index::class, ['board' => $board])->call('leave')->assertRedirect(route('boards.index'));
    expect($membership->exists())->toBeFalse();
});

test('users will get an email when someone leaves the board', function () {
    $this->actingAs($user = User::factory()->create());
    $boardOwner = User::factory()->create();
    $alreadyMember = User::factory()->create();
    $board = Board::factory()->for($boardOwner)->create();
    Membership::factory()->for($alreadyMember)->for($board)->create();
    Membership::factory()->for($user)->for($board)->create();
    Mail::assertNothingQueued();

    Livewire::test(Index::class, ['board' => $board])->call('leave')->assertRedirect(route('boards.index'));

    // The board owner will get an email when someone leaves a board
    Mail::assertQueued(BoardLeftMail::class, fn ($mail) => $mail->hasTo($boardOwner->email));

    // All members will get an email when someone leaves a board
    Mail::assertQueued(BoardLeftMail::class, fn ($mail) => $mail->hasTo($alreadyMember->email));

    // The leaving member won't get an email when he leaves a board
    Mail::assertNotQueued(BoardLeftMail::class, fn ($mail) => $mail->hasTo($user->email));
});

test('a user can leave the board when the board is archived', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->archived()->create();
    $membership = Membership::factory()->for($user)->for($board)->create();

    expect($membership->exists())->toBeTrue();
    Livewire::test(Index::class, ['board' => $board])->call('leave')->assertRedirect(route('boards.index'));
    expect($membership->exists())->toBeFalse();
});
