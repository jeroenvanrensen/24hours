<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\RequestPasswordLink;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

/** @group auth */
class RequestPasswordLinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_request_password_page()
    {
        $this->withoutExceptionHandling();
        
        $this->get(route('password.request'))
            ->assertStatus(200)
            ->assertSeeLivewire('auth.request-password-link');
    }
    
    /** @test */
    public function authenticated_users_cannot_visit_the_request_password_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('password.request'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function a_user_can_request_a_new_password()
    {
        $this->withoutExceptionHandling();

        Notification::fake();

        $user = User::factory()->create();
        
        $this->assertDatabaseCount('password_resets', 0);

        Livewire::test(RequestPasswordLink::class)
            ->set('email', $user->email)
            ->call('request')
            ->assertHasNoErrors();

        Notification::assertSentTo($user, ResetPassword::class);
        
        $this->assertDatabaseCount('password_resets', 1);

        $this->assertDatabaseHas('password_resets', [
            'email' => $user->email
        ]);
    }

    /** @test */
    public function the_email_has_to_exist()
    {
        Livewire::test(RequestPasswordLink::class)
            ->set('email', 'john@example.org') // email does not exist
            ->call('request')
            ->assertHasErrors('email');
    }
}
