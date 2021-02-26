<?php

namespace Tests\Feature\Invitations;

use App\Http\Livewire\Invitations\Show;
use App\Mail\InvitationAcceptedMail;
use App\Mail\InvitationDeniedMail;
use App\Mail\NewMemberMail;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/** @group invitations */
class AcceptInvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_accept_invitation_page()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        $this->get(route('invitations.show', $invitation))
            ->assertStatus(200)
            ->assertSeeLivewire('invitations.show');
    }

    /** @test */
    public function non_invited_users_cannot_visit_the_accept_invitation_page()
    {
        Mail::fake();

        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        $this->get(route('invitations.show', $invitation))
            ->assertStatus(403);
    }

    /** @test */
    public function guests_get_redirected_to_the_login_page()
    {
        Mail::fake();

        $user = User::factory()->create();

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        $this->get(route('invitations.show', $invitation))
            ->assertRedirect(route('login'));
    }
    
    /** @test */
    public function guests_get_redirected_to_the_register_page_if_they_dont_have_an_account_yet()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => 'john@example.org']);

        $this->get(route('invitations.show', $invitation))
            ->assertRedirect(route('register'));
    }

    /** @test */
    public function a_user_can_accept_an_invitation()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        $this->assertCount(1, Invitation::all());
        $this->assertCount(0, Membership::all());

        Livewire::test(Show::class, ['invitation' => $invitation])
            ->call('accept')
            ->assertRedirect(route('boards.show', $board));
            
        $this->assertCount(0, Invitation::all());
        $this->assertCount(1, Membership::all());

        $this->assertDatabaseHas('memberships', [
            'board_id' => $board->id,
            'user_id' => $user->id,
            'role' => $invitation->role
        ]);
    }

    /** @test */
    public function the_board_owner_will_get_an_email_when_someone_accepts_an_invitation()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $boardOwner = User::factory()->create();
        $board = Board::factory()->for($boardOwner)->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        Mail::assertNothingQueued();

        Livewire::test(Show::class, ['invitation' => $invitation])
            ->call('accept')
            ->assertRedirect(route('boards.show', $board));

        Mail::assertQueued(InvitationAcceptedMail::class, function(InvitationAcceptedMail $mail) use ($boardOwner) {
            return $mail->hasTo($boardOwner->email);
        });

        Mail::assertNotQueued(NewMemberMail::class);
    }

    /** @test */
    public function all_board_members_will_get_an_email_when_someone_accepts_an_invitation()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $alreadyBoardMember = User::factory()->create();
        $board = Board::factory()->create();
        $membership = Membership::factory()->for($alreadyBoardMember)->for($board)->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        Mail::assertNothingQueued();

        Livewire::test(Show::class, ['invitation' => $invitation])
            ->call('accept')
            ->assertRedirect(route('boards.show', $board));

        Mail::assertQueued(NewMemberMail::class, function(NewMemberMail $mail) use ($alreadyBoardMember) {
            return $mail->hasTo($alreadyBoardMember->email);
        });

        Mail::assertNotQueued(InvitationAcceptedMail::class, function(InvitationAcceptedMail $mail) use ($alreadyBoardMember) {
            return $mail->hasTo($alreadyBoardMember->email);
        });
    }

    /** @test */
    public function a_user_can_deny_an_invitation()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        $this->assertCount(1, Invitation::all());
        $this->assertCount(0, Membership::all());

        Livewire::test(Show::class, ['invitation' => $invitation])
            ->call('deny')
            ->assertRedirect(route('invitations.check'));
            
        $this->assertCount(0, Invitation::all());
        $this->assertCount(0, Membership::all());
    }

    /** @test */
    public function the_board_owner_gets_an_email_when_someone_denies_an_invitation()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $boardOwner = User::factory()->create();
        $board = Board::factory()->for($boardOwner)->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        Mail::assertNothingQueued();

        Livewire::test(Show::class, ['invitation' => $invitation])
            ->call('deny')
            ->assertRedirect(route('invitations.check'));

        Mail::assertQueued(InvitationDeniedMail::class, function(InvitationDeniedMail $mail) use ($boardOwner) {
            return $mail->hasTo($boardOwner->email);
        });
    }

    /** @test */
    public function members_dont_get_an_email_when_someone_denies_an_invitation()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $alreadyMember = User::factory()->create();
        $board = Board::factory()->create();
        $membership = Membership::factory()->for($alreadyMember)->for($board)->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        Livewire::test(Show::class, ['invitation' => $invitation])
            ->call('deny')
            ->assertRedirect(route('invitations.check'));

        Mail::assertNotQueued(InvitationDeniedMail::class, function(InvitationDeniedMail $mail) use ($alreadyMember) {
            return $mail->hasTo($alreadyMember->email);
        });
    }
}
