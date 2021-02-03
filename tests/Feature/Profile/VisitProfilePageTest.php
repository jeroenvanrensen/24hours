<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitProfilePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_profile_page()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('profile.edit'))
            ->assertStatus(200)
            ->assertSeeLivewire('profile.edit')
            ->assertSeeLivewire('profile.profile-info')
            ->assertSeeLivewire('profile.password')
            ->assertSeeLivewire('profile.delete-account');
    }

    /** @test */
    public function guests_cannot_visit_the_profile_page()
    {
        $this->get(route('profile.edit'))
            ->assertRedirect(route('login'));
    }
}
