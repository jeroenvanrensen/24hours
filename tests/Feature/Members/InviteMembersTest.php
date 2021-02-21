<?php

namespace Tests\Feature\Members;

use App\Http\Livewire\Members\Create;
use App\Mail\Members\InvitationMail;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class InviteMembersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_invite_a_member()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $userToBeInvited = User::factory()->create();

        $board = Board::factory()->for($user)->create();

        $this->assertCount(0, Invitation::all());
        
        Livewire::test(Create::class, ['board' => $board])
            ->set('email', $userToBeInvited->email)
            ->set('role', 'member')
            ->call('invite');

        $this->assertCount(1, Invitation::all());

        $this->assertDatabaseHas('invitations', [
            'board_id' => $board->id,
            'email' => $userToBeInvited->email,
            'role' => 'member'
        ]);
    }

    /** @test */
    public function a_user_cannot_be_invited_twice()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $userToBeInvited = User::factory()->create();

        $board = Board::factory()->for($user)->create();
        
        $invitation = Invitation::create([
            'board_id' => $board->id,
            'email' => $userToBeInvited->email,
            'role' => 'member'
        ]);

        $this->assertCount(1, Invitation::all());
    
        Livewire::test(Create::class, ['board' => $board])
            ->set('email', $userToBeInvited->email)
            ->set('role', 'viewer')
            ->call('invite')
            ->assertHasErrors('email');

        $this->assertCount(1, Invitation::all());

        Mail::assertNothingQueued();
    }

    /** @test */
    public function users_who_are_already_members_cannot_be_invited_again()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $otherUser = User::factory()->create();
        $membership = Membership::factory()->create(['board_id' => $board->id, 'user_id' => $otherUser->id]);
    
        Livewire::test(Create::class, ['board' => $board])
            ->set('email', $otherUser->email)
            ->set('role', 'viewer')
            ->call('invite')
            ->assertHasErrors('email');

        Mail::assertNothingQueued();
    }

    /** @test */
    public function an_invitation_requires_an_existing_email()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        
        Livewire::test(Create::class, ['board' => $board])
            ->set('email', 'john@example.org') // does not exists
            ->set('role', 'member')
            ->call('invite')
            ->assertHasErrors('email');
    }

    /** @test */
    public function an_invitation_requires_an_existing_role()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

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
    }

    /** @test */
    public function an_invited_member_gets_a_link_mailed_to_join_a_board()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $userToBeInvited = User::factory()->create();

        $board = Board::factory()->for($user)->create();

        Mail::assertNothingQueued();
        
        Livewire::test(Create::class, ['board' => $board])
            ->set('email', $userToBeInvited->email)
            ->set('role', 'member')
            ->call('invite');

        Mail::assertQueued(function(InvitationMail $mail) use ($userToBeInvited) {
            return $mail->hasTo($userToBeInvited->email);
        });
    }

    /** @test */
    public function a_user_can_accept_an_invitation()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        $this->assertTrue($invitation->exists());
        $this->assertCount(0, Membership::all());

        $this->get(route('members.store', $invitation))
            ->assertRedirect(route('boards.show', $board));

        $this->assertFalse($invitation->exists());
        $this->assertCount(1, Membership::all());

        $this->assertDatabaseHas('memberships', [
            'user_id' => $user->id,
            'board_id' => $board->id
        ]);
    }

    /** @test */
    public function a_user_cannot_accept_an_other_invitation()
    {
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $this->actingAs($otherUser);

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        $this->get(route('members.store', $invitation))
            ->assertStatus(403);
    }

    /** @test */
    public function guests_cannot_accept_an_invitation()
    {
        $user = User::factory()->create();

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => $user->email]);

        $this->assertTrue($invitation->exists());

        $this->get(route('members.store', $invitation))
            ->assertRedirect(route('login'));
    }
}
