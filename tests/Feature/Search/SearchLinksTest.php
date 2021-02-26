<?php

namespace Tests\Feature\Search;

use App\Http\Livewire\Search\Search;
use App\Models\Board;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group search */
class SearchLinksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_their_links()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $firstLink = Link::factory()->for($board)->create(['title' => 'First Link']);
        $secondLink = Link::factory()->for($board)->create(['title' => 'Second Link']);

        Livewire::test(Search::class)
            ->assertDontSee($firstLink->title)
            ->assertDontSee($secondLink->title)
            ->set('query', 'First')
            ->assertSee($firstLink->title)
            ->assertDontSee($secondLink->title);
    }

    /** @test */
    public function a_user_cannot_see_a_link_they_dont_own()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(); // other user
        $link = Link::factory()->for($board)->create();

        Livewire::test(Search::class)   
            ->set('query', $link->title)
            ->assertDontSee($link->title);
    }

    /** @test */
    public function the_links_are_sorted_by_date()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $firstLink = Link::factory()->for($board)->create(['title' => 'First Link', 'updated_at' => now()->subWeek()]);
        $secondLink = Link::factory()->for($board)->create(['title' => 'Second Link', 'updated_at' => now()]);

        Livewire::test(Search::class)
            ->set('query', 'Link')
            ->assertSeeInOrder([
                $secondLink->title,
                $firstLink->title
            ]);
    }
}
