<?php

namespace Tests\Feature\Memberships;

use App\Http\Livewire\Memberships\Create;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InviteMembersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_invite_a_member()
    {
        $this->withoutExceptionHandling();

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
    public function an_invitation_requires_an_existing_email()
    {
        $this->withoutExceptionHandling();

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
}
