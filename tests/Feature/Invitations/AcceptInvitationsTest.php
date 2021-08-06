<?php

use App\Http\Livewire\Invitations\Show;
use App\Mail\InvitationAcceptedMail;
use App\Mail\InvitationDeniedMail;
use App\Mail\NewMemberMail;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

beforeEach(function () {
    $this->withoutExceptionHandling();
    Mail::fake();
});

test('a user can visit the accept invitation page', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    $this->get(route('invitations.show', $invitation))
        ->assertStatus(200)
        ->assertSeeLivewire('invitations.show');
});

test('non invited users cannot visit the accept invitation page', function () {
    $this->withExceptionHandling();
    $user = User::factory()->create();

    $otherUser = User::factory()->create();
    $this->actingAs($otherUser);

    $board = Board::factory()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    $this->get(route('invitations.show', $invitation))->assertStatus(403);
});

test('guests get redirected to the login page', function () {
    $user = User::factory()->create();
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    $this->get(route('invitations.show', $invitation))->assertRedirect(route('login'));
});

test('guests get redirected to the register page if they dont have an account yet', function () {
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => 'john@example.org']);

    $this->get(route('invitations.show', $invitation))->assertRedirect(route('register'));
});

test('a user can accept an invitation', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    expect(Invitation::all())->toHaveCount(1);
    expect(Membership::all())->toHaveCount(0);

    Livewire::test(Show::class, ['invitation' => $invitation])
        ->call('accept')
        ->assertRedirect(route('boards.show', $board));

    expect(Invitation::all())->toHaveCount(0);
    expect(Membership::all())->toHaveCount(1);

    tap(Membership::first(), function ($membership) use ($board, $user, $invitation) {
        expect($membership->board_id)->toBe($board->id);
        expect($membership->user_id)->toBe($user->id);
        expect($membership->role)->toBe($invitation->role);
    });
});

test('a user cannot accept an invitation if the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->archived()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    Livewire::test(Show::class, ['invitation' => $invitation])->call('accept')->assertStatus(403);

    expect(Invitation::all())->toHaveCount(1);
    expect(Membership::all())->toHaveCount(0);
});

test('the board owner will get an email when someone accepts an invitation', function () {
    $this->actingAs($user = User::factory()->create());
    $boardOwner = User::factory()->create();
    $board = Board::factory()->for($boardOwner)->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);
    Mail::assertNothingQueued();

    Livewire::test(Show::class, ['invitation' => $invitation])
        ->call('accept')
        ->assertRedirect(route('boards.show', $board));

    Mail::assertQueued(InvitationAcceptedMail::class, fn ($mail) => $mail->hasTo($boardOwner->email));
    Mail::assertNotQueued(NewMemberMail::class);
});

test('all board members will get an email when someone accepts an invitation', function () {
    $this->actingAs($user = User::factory()->create());
    $alreadyBoardMember = User::factory()->create();
    $board = Board::factory()->create();
    Membership::factory()->for($alreadyBoardMember)->for($board)->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);
    Mail::assertNothingQueued();

    Livewire::test(Show::class, ['invitation' => $invitation])->call('accept')->assertRedirect(route('boards.show', $board));

    Mail::assertQueued(NewMemberMail::class, fn ($mail) => $mail->hasTo($alreadyBoardMember->email));
    Mail::assertQueued(InvitationAcceptedMail::class, fn ($mail) => $mail->hasTo($board->user->email));
});

test('a user can deny an invitation', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    expect(Invitation::all())->toHaveCount(1);
    expect(Membership::all())->toHaveCount(0);

    Livewire::test(Show::class, ['invitation' => $invitation])->call('deny')->assertRedirect(route('invitations.check'));

    expect(Invitation::all())->toHaveCount(0);
    expect(Membership::all())->toHaveCount(0);
});

test('a user cannot deny an invitation when the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->archived()->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    Livewire::test(Show::class, ['invitation' => $invitation])->call('deny')->assertStatus(403);

    expect(Invitation::all())->toHaveCount(1);
    expect(Membership::all())->toHaveCount(0);
});

test('the board owner gets an email when someone denies an invitation', function () {
    $this->actingAs($user = User::factory()->create());
    $boardOwner = User::factory()->create();
    $board = Board::factory()->for($boardOwner)->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    Mail::assertNothingQueued();
    Livewire::test(Show::class, ['invitation' => $invitation])->call('deny')->assertRedirect(route('invitations.check'));
    Mail::assertQueued(InvitationDeniedMail::class, fn ($mail) => $mail->hasTo($boardOwner->email));
});

test('members dont get an email when someone denies an invitation', function () {
    $this->actingAs($user = User::factory()->create());
    $alreadyMember = User::factory()->create();
    $board = Board::factory()->create();
    Membership::factory()->for($alreadyMember)->for($board)->create();
    $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

    Livewire::test(Show::class, ['invitation' => $invitation])->call('deny')->assertRedirect(route('invitations.check'));
    Mail::assertNotQueued(InvitationDeniedMail::class, fn ($mail) => $mail->hasTo($alreadyMember->email));
});
