<?php

namespace Tests\Feature\Links;

use App\Http\Livewire\Links\Index;
use App\Models\Board;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SeeLinksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_see_all_links()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $link = Link::factory()->for($board)->create();

        Livewire::test(Index::class, ['board' => $board])
            ->assertSee($link->title);
    }

    /** @test */
    public function the_links_are_ordered_by_date()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $firstLink = Link::factory()->for($board)->create(['created_at' => now()->subWeek()]);
        $lastLink = Link::factory()->for($board)->create(['created_at' => now()]);

        Livewire::test(Index::class, ['board' => $board])
            ->assertSeeInOrder([
                $lastLink->title,
                $firstLink->title
            ]);
    }

    /** @test */
    public function only_the_last_50_links_are_shown()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $firstLink = Link::factory()->for($board)->create(['created_at' => now()->subWeeks(2)]);
        Link::factory()->for($board)->count(60)->create(['created_at' => now()->subWeek()]);
        $lastLink = Link::factory()->for($board)->create(['created_at' => now()]);

        Livewire::test(Index::class, ['board' => $board])
            ->assertSee($lastLink->title)
            ->assertDontSee($firstLink->title);
    }

    /** @test */
    public function a_user_can_load_more_links()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $firstLink = Link::factory()->for($board)->create(['created_at' => now()->subWeeks(2)]);
        Link::factory()->for($board)->count(60)->create(['created_at' => now()->subWeek()]);
        $lastLink = Link::factory()->for($board)->create(['created_at' => now()]);

        Livewire::test(Index::class, ['board' => $board])
            ->assertSee($lastLink->title)
            ->assertDontSee($firstLink->title)
            ->call('loadMore')
            ->assertSee($lastLink->title)
            ->assertSee($firstLink->title);
    }
}
