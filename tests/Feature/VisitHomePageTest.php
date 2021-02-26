<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @group feature */
class VisitHomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_home_page()
    {
        $this->withoutExceptionHandling();
        
        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSeeLivewire('home');
    }

    /** @test */
    public function authenticated_users_get_redirected_when_they_visit_the_home_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('home'))
            ->assertRedirect(route('boards.index'));
    }
}
