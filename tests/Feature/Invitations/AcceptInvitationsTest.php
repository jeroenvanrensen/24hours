<?php

namespace Tests\Feature\Invitations;

use App\Http\Livewire\Invitations\Show;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AcceptInvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_accept_invitation_page()
    {
        $this->withoutExceptionHandling();
        
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

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->create(['board_id' => $board->id, 'email' => 'john@example.org']);

        $this->get(route('invitations.show', $invitation))
            ->assertRedirect(route('register'));
    }

    /** @test */
    public function a_user_can_accept_an_invitation()
    {
        $this->withoutExceptionHandling();
        
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
    public function a_user_can_deny_an_invitation()
    {
        $this->withoutExceptionHandling();
        
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
}
