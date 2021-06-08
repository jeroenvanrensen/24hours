<?php

namespace Tests\Feature\Invitations;

use App\Models\Board;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @group invitations */
class CheckForInvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_invitations_page()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('invitations.check'))
            ->assertRedirect(route('boards.index'));
    }

    /** @test */
    public function guests_cannot_visit_the_invitations_page()
    {
        $this->get(route('invitations.check'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_gets_redirected_to_an_invitation_if_there_are_any()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

        $this->get(route('invitations.check'))
            ->assertRedirect(route('invitations.show', $invitation));
    }

    /** @test */
    public function a_user_does_not_get_redirected_to_an_invitation_if_the_board_is_archived()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(['archived' => true]);
        $invitation = Invitation::factory()->for($board)->create(['email' => $user->email]);

        $this->get(route('invitations.check'))
            ->assertRedirect(route('boards.index'));
    }
}
