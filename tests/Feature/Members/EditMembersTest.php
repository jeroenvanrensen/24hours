<?php

use App\Http\Livewire\Members\Edit;
use App\Mail\MembershipUpdatedMail;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

beforeEach(fn () => Mail::fake());

test('a board owner can visit the edit membership page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    $this->get(route('members.edit', [$board, $membership]))
        ->assertStatus(200)
        ->assertSeeLivewire('members.edit')
        ->assertSeeLivewire('members.delete');
});

test('members cannot visit the edit membership page', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    $this->get(route('members.edit', [$board, $membership]))->assertStatus(403);
});

test('viewers cannot visit the edit membership page', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    $this->get(route('members.edit', [$board, $membership]))->assertStatus(403);
});

test('non members cannot visit the edit membership page', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    $this->get(route('members.edit', [$board, $membership]))->assertStatus(403);
});

test('guests cannot visit the edit membership page', function () {
    $this->withExceptionHandling();
    $board = Board::factory()->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    $this->get(route('members.edit', [$board, $membership]))->assertRedirect(route('login'));
});

test('the board owner cannot visit the edit membership page when the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create(['archived' => true]);

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    $this->get(route('members.edit', [$board, $membership]))->assertStatus(403);
});

test('the owner can edit a membership', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->member()->create();

    expect($membership->fresh()->role)->not()->toBe('viewer');

    Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
        ->set('role', 'viewer')
        ->call('update')
        ->assertRedirect(route('members.index', $board));

    expect($membership->fresh()->role)->toBe('viewer');
});

it('requires a valid role', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create();

    Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
        ->set('role', 'member')
        ->call('update')
        ->assertHasNoErrors();

    Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
        ->set('role', 'viewer')
        ->call('update')
        ->assertHasNoErrors();

    Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
        ->set('role', 'invalid-role')
        ->call('update')
        ->assertHasErrors('role');
});

test('the member gets an email when their membership is changed', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create(['role' => 'member']);

    Mail::assertNothingQueued();
    Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])->set('role', 'viewer')->call('update');
    Mail::assertQueued(MembershipUpdatedMail::class, fn ($mail) => $mail->hasTo($member->email));
});

test('the member does not get an email when the membership stays the same', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $member = User::factory()->create();
    $membership = Membership::factory()->for($member)->for($board)->create(['role' => 'member']);

    Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])->set('role', 'member')->call('update'); // same role
    Mail::assertNothingQueued();
});
