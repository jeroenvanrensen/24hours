<?php

use App\Http\Livewire\Members\Delete;
use App\Mail\MemberRemovedMail;
use App\Mail\YouAreRemovedMail;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

beforeEach(function () {
    $this->withoutExceptionHandling();
    Mail::fake();
});

test('a board owner can remove a member', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();
    expect($membership->exists())->toBeTrue();

    Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
        ->call('destroy')
        ->assertRedirect(route('members.index', $board));

    expect($membership->exists())->toBeFalse();
});

test('members cannot remove a member', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
        ->call('destroy')
        ->assertStatus(403);

    expect($membership->exists())->toBeTrue();
});

test('viewers cannot remove a member', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
        ->call('destroy')
        ->assertStatus(403);

    expect($membership->exists())->toBeTrue();
});

test('non-members cannot remove a member', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
        ->call('destroy')
        ->assertStatus(403);

    expect($membership->exists())->toBeTrue();
});

test('guests cannot remove a member', function () {
    $this->withExceptionHandling();
    $board = Board::factory()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
        ->call('destroy')
        ->assertStatus(403);

    expect($membership->exists())->toBeTrue();
});

test('members will get an email when they are removed', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();
    Mail::assertNothingQueued();

    Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
        ->call('destroy')
        ->assertRedirect(route('members.index', $board));

    Mail::assertQueued(YouAreRemovedMail::class, fn ($mail) => $mail->hasTo($member->email));
    Mail::assertNotQueued(MemberRemovedMail::class);
});

test('all other members will get an email when someone is removed', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $oldMember = User::factory()->create();
    Membership::factory()->for($oldMember)->for($board)->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();
    Mail::assertNothingQueued();

    Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
        ->call('destroy')
        ->assertRedirect(route('members.index', $board));

    Mail::assertQueued(MemberRemovedMail::class, fn ($mail) => $mail->hasTo($oldMember->email));
    Mail::assertNotQueued(YouAreRemovedMail::class, fn ($mail) => $mail->hasTo($oldMember->email));
});

test('a board owner cannot remove a member when the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])->call('destroy')->assertStatus(403);
    expect($membership->exists())->toBeTrue();
});
