<?php

namespace Tests\Feature\Search;

use App\Http\Livewire\Search\Search;
use App\Models\Board;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group search */
class SearchBoardsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_their_boards()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $firstBoard = Board::factory()->for($user)->create(['name' => 'First Board']);
        $secondBoard = Board::factory()->for($user)->create(['name' => 'Second Board']);

        Livewire::test(Search::class)
            ->assertDontSee($firstBoard->name)
            ->assertDontSee($secondBoard->name)
            ->set('query', 'First')
            ->assertSee($firstBoard->name)
            ->assertDontSee($secondBoard->name);
    }

    /** @test */
    public function a_user_cannot_see_boards_they_dont_own()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(['name' => 'My Board']); // other user

        Livewire::test(Search::class)
            ->set('query', 'My')
            ->assertDontSee($board->name);
    }

    /** @test */
    public function the_boards_are_sorted_by_date()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $firstBoard = Board::factory()->for($user)->create(['name' => 'First Board', 'updated_at' => now()->subWeek()]);
        $secondBoard = Board::factory()->for($user)->create(['name' => 'Second Board', 'updated_at' => now()]);

        Livewire::test(Search::class)
            ->set('query', 'Board')
            ->assertSeeInOrder([
                $secondBoard->name,
                $firstBoard->name
            ]);
    }
}
