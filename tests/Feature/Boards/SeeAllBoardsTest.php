<?php

namespace Tests\Feature\Boards;

use App\Http\Livewire\Boards\Index;
use App\Models\Board;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SeeAllBoardsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_boards_index_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('boards.index'))
            ->assertStatus(200)
            ->assertSeeLivewire('boards.index')
            ->assertSeeLivewire('boards.create');
    }

    /** @test */
    public function guests_cannot_visit_the_boards_index_page()
    {
        $this->get(route('boards.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_see_all_their_boards()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        Livewire::test(Index::class)
            ->assertSee($board->name);
    }

    /** @test */
    public function a_user_cannot_see_boards_they_dont_own()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(); // other user

        Livewire::test(Index::class)
            ->assertDontSee($board->name);
    }

    /** @test */
    public function the_boards_are_ordered_by_date()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $firstBoard = Board::factory()->for($user)->create(['updated_at' => now()->subWeek()]);
        $lastBoard = Board::factory()->for($user)->create(['updated_at' => now()]);

        Livewire::test(Index::class)
            ->assertSeeInOrder([
                $lastBoard->name,
                $firstBoard->name
            ]);
    }
}
