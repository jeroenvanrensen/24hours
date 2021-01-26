<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_dashboard()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('dashboard'))
            ->assertStatus(200)
            ->assertSeeLivewire('dashboard');
    }

    /** @test */
    public function guests_cannot_visit_the_dashboard()
    {
        $this->get(route('dashboard'))
            ->assertRedirect('/login');
    }
}
