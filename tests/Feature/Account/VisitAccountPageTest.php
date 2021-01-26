<?php

namespace Tests\Feature\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitAccountPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_account_page()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('account.edit'))
            ->assertStatus(200)
            ->assertSeeLivewire('account.edit')
            ->assertSeeLivewire('account.profile-info')
            ->assertSeeLivewire('account.password');
    }

    /** @test */
    public function guests_cannot_visit_the_account_page()
    {
        $this->get(route('account.edit'))
            ->assertRedirect(route('login'));
    }
}
