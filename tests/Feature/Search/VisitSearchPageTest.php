<?php

namespace Tests\Feature\Search;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @group search */
class VisitSearchPageTest extends TestCase
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
}
