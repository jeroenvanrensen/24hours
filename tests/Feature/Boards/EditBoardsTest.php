<?php

namespace Tests\Feature\Boards;

use App\Http\Livewire\Boards\Edit;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditBoardsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_edit_board_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->get(route('boards.edit', $board))
            ->assertStatus(200)
            ->assertSeeLivewire('boards.edit');
    }

    /** @test */
    public function guests_cannot_visit_the_edit_board_page()
    {
        $board = Board::factory()->create();

        $this->get(route('boards.edit', $board))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function other_users_cannot_visit_the_edit_board_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(); // other user

        $this->get(route('boards.edit', $board))
            ->assertStatus(403);
    }

    /** @test */
    public function members_cannot_visit_the_edit_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        $this->get(route('boards.edit', $board))
            ->assertStatus(403);
    }

    /** @test */
    public function viewer_cannot_visit_the_edit_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        $this->get(route('boards.edit', $board))
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_edit_a_board()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->assertNotEquals('New Board Name', $board->fresh()->name);

        Livewire::test(Edit::class, ['board' => $board])
            ->set('board.name', 'New Board Name')
            ->call('update')
            ->assertRedirect(route('boards.show', $board));

        $this->assertEquals('New Board Name', $board->fresh()->name);
    }

    /** @test */
    public function a_board_requires_a_name()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        Livewire::test(Edit::class, ['board' => $board])
            ->set('board.name', null)
            ->call('update')
            ->assertHasErrors('board.name');
    }
}
