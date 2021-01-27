<?php

namespace Tests\Feature\Links;

use App\Models\Board;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitLinksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_a_link()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        
        $board = Board::factory()->for($user)->create();
        $link = Link::factory()->for($board)->create();

        $this->get(route('links.show', $link))
            ->assertRedirect($link->url);
    }

    /** @test */
    public function guests_cannot_visit_a_link()
    {
        $link = Link::factory()->create();

        $this->get(route('links.show', $link))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function non_owners_cannot_visit_a_link_they_dont_own()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $board = Board::factory()->create(); // other user
        $link = Link::factory()->for($board)->create();

        $this->get(route('links.show', $link))
            ->assertStatus(403);
    }

    /** @test */
    public function the_updated_at_timestamp_is_updated_after_visiting_a_link()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        
        $board = Board::factory()->for($user)->create();
        $link = Link::factory()->for($board)->create(['updated_at' => now()->subWeek()]);

        // Assert that the link was last updated longer than 60 seconds ago
        $this->assertTrue($link->fresh()->updated_at->diffInSeconds() > 60);

        $this->get(route('links.show', $link))
            ->assertRedirect($link->url);

        // Assert that the link was last updated between now and 60 seconds ago
        $this->assertTrue($link->fresh()->updated_at->diffInSeconds() < 60);
    }
}
