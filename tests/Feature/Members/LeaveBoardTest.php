<?php

namespace Tests\Feature\Members;

use App\Http\Livewire\Members\Index;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LeaveBoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_board_owner_cannot_leave_a_board()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        Livewire::test(Index::class, ['board' => $board])
            ->call('leave')
            ->assertStatus(403);
    }

    /** @test */
    public function a_member_can_leave_a_board()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        $this->assertTrue($membership->exists());

        Livewire::test(Index::class, ['board' => $board])
            ->call('leave')
            ->assertRedirect(route('boards.index'));
        
        $this->assertFalse($membership->exists());
    }

    /** @test */
    public function a_viewer_can_leave_a_board()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        $this->assertTrue($membership->exists());

        Livewire::test(Index::class, ['board' => $board])
            ->call('leave')
            ->assertRedirect(route('boards.index'));
        
        $this->assertFalse($membership->exists());
    }
}
