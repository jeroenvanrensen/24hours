<?php

use App\Http\Livewire\Members\Create;
use App\Mail\InvitationMail;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use function Pest\Faker\faker;

beforeEach(fn () => Mail::fake());

test('a board owner can invite a member', function () {
    $this->actingAs($user = User::factory()->create());
    $userToBeInvited = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    $role = Arr::random(['viewer', 'member']);
    expect(Invitation::all())->toHaveCount(0);

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', $userToBeInvited->email)
        ->set('role', $role)
        ->call('invite');

    expect(Invitation::all())->toHaveCount(1);
    tap(Invitation::first(), function ($invitation) use ($board, $userToBeInvited, $role) {
        expect($invitation->board_id)->toBe($board->id);
        expect($invitation->email)->toBe($userToBeInvited->email);
        expect($invitation->role)->toBe($role);
    });
});

test('members cannot invite a user', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', 'john@example.org')
        ->set('role', 'member')
        ->call('invite')
        ->assertStatus(403);

    expect(Invitation::all())->toHaveCount(0);
});

test('viewers cannot invite a user', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', 'john@example.org')
        ->set('role', 'member')
        ->call('invite')
        ->assertStatus(403);

    expect(Invitation::all())->toHaveCount(0);
});

test('a user cannot be invited twice', function () {
    $this->actingAs($user = User::factory()->create());
    $userToBeInvited = User::factory()->create();
    $board = Board::factory()->for($user)->create();

    Invitation::create([
        'board_id' => $board->id,
        'email' => $userToBeInvited->email,
        'role' => 'member',
    ]);
    expect(Invitation::all())->toHaveCount(1);

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', $userToBeInvited->email)
        ->set('role', 'viewer')
        ->call('invite')
        ->assertHasErrors('email');

    expect(Invitation::all())->toHaveCount(1);
    Mail::assertNothingQueued();
});

test('users who are already members cannot be invited again', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    $otherUser = User::factory()->create();
    Membership::factory()->create(['board_id' => $board->id, 'user_id' => $otherUser->id]);

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', $otherUser->email)
        ->set('role', 'viewer')
        ->call('invite')
        ->assertHasErrors('email');

    Mail::assertNothingQueued();
});

test('non existing users can be invited', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $email = faker()->email();
    $role = Arr::random(['viewer', 'member']);
    expect(Invitation::all())->toHaveCount(0);

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', $email) // does not exists
        ->set('role', $role)
        ->call('invite')
        ->assertHasNoErrors('email');

    expect(Invitation::all())->toHaveCount(1);
    tap(Invitation::first(), function ($invitation) use ($board, $email, $role) {
        expect($invitation->board_id)->toBe($board->id)
            ->and($invitation->email)->toBe($email)
            ->and($invitation->role)->toBe($role);
    });
});

it('requires an existing role', function () {
    $this->actingAs($user = User::factory()->create());
    $userToBeInvited = User::factory()->create();
    $board = Board::factory()->for($user)->create();

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', $userToBeInvited->email)
        ->set('role', 'member')
        ->call('invite')
        ->assertHasNoErrors('role');

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', $userToBeInvited->email)
        ->set('role', 'viewer')
        ->call('invite')
        ->assertHasNoErrors('role');

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', $userToBeInvited->email)
        ->set('role', 'admin') // invalid role
        ->call('invite')
        ->assertHasErrors('role');
});

test('an invited user gets a link mailed to join the board', function () {
    $this->actingAs($user = User::factory()->create());
    $userToBeInvited = User::factory()->create();
    $board = Board::factory()->for($user)->create();
    Mail::assertNothingQueued();

    Livewire::test(Create::class, ['board' => $board])
        ->set('email', $userToBeInvited->email)
        ->set('role', 'member')
        ->call('invite');

    Mail::assertQueued(InvitationMail::class, fn ($mail) => $mail->hasTo($userToBeInvited->email));
});
