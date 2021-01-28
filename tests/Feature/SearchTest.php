<?php

namespace Tests\Feature;

use App\Http\Livewire\Search\Search;
use App\Models\Board;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_search_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('search'))
            ->assertStatus(200)
            ->assertSeeLivewire('search.search');
    }

    /** @test */
    public function guests_cannot_visit_the_search_page()
    {
        $this->get(route('search'))
            ->assertRedirect(route('login'));
    }

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
