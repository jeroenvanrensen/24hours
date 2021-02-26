<?php

namespace Tests\Feature\Boards;

use App\Http\Livewire\Boards\Show;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group boards */
class SeeSingleBoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_a_single_board_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->get(route('boards.show', $board))
            ->assertStatus(200)
            ->assertSeeLivewire('boards.show')
            ->assertSeeLivewire('links.create')
            ->assertSeeLivewire('items.index');
    }

    /** @test */
    public function guests_cannot_visit_a_single_board_page()
    {
        $board = Board::factory()->create();

        $this->get(route('boards.show', $board))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function members_can_visit_a_single_board_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        $this->get(route('boards.show', $board))
            ->assertStatus(200)
            ->assertSeeLivewire('boards.show')
            ->assertSeeLivewire('links.create')
            ->assertSeeLivewire('items.index');
    }

    /** @test */
    public function viewers_can_visit_a_single_board_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        $this->get(route('boards.show', $board))
            ->assertStatus(200)
            ->assertSeeLivewire('boards.show')
            ->assertDontSeeLivewire('links.create')
            ->assertSeeLivewire('items.index');
    }

    /** @test */
    public function other_users_cannot_visit_a_single_board_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(); // other user

        $this->get(route('boards.show', $board))
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_see_the_board_name_at_the_board_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        Livewire::test(Show::class,['board' => $board])
            ->assertSee($board->name);
    }

    /** @test */
    public function the_updated_at_timestamp_is_updated_after_visiting_the_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create(['updated_at' => now()->subWeek()]);

        // Assert that the board was last updated longer than 60 seconds ago
        $this->assertTrue($board->fresh()->updated_at->diffInSeconds() > 60);

        Livewire::test(Show::class,['board' => $board])
            ->assertSee($board->name);

        // Assert that the board was last updated between now and 60 seconds ago
        $this->assertTrue($board->fresh()->updated_at->diffInSeconds() < 60);
    }
}
