<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\Login;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_login_page()
    {
        $this->withoutExceptionHandling();
        
        $this->get(route('login'))
            ->assertStatus(200)
            ->assertSeeLivewire('auth.login');
    }

    /** @test */
    public function authenticated_users_cannot_visit_the_login_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('login'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function a_user_can_login()
    {
        $this->withoutExceptionHandling();
        
        User::factory()->create([
            'email' => 'john@example.org',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $this->assertFalse(auth()->check());

        Livewire::test(Login::class)
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->call('login')
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertTrue(auth()->check());
    }

    /** @test */
    public function a_user_cannot_login_if_the_email_is_incorrect()
    {
        $this->withoutExceptionHandling();
        
        User::factory()->create([
            'email' => 'john@example.org',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $this->assertFalse(auth()->check());

        Livewire::test(Login::class)
            ->set('email', 'jane@example.org') // wrong email
            ->set('password', 'password')
            ->call('login')
            ->assertHasErrors('email', 'These credentials do not match our records.');

        $this->assertFalse(auth()->check());
    }

    /** @test */
    public function a_user_cannot_login_if_the_password_is_incorrect()
    {
        $this->withoutExceptionHandling();
        
        User::factory()->create([
            'email' => 'john@example.org',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $this->assertFalse(auth()->check());

        Livewire::test(Login::class)
            ->set('email', 'john@example.org')
            ->set('password', 'wrong-password') // wrong password
            ->call('login')
            ->assertHasErrors('email', 'These credentials do not match our records.');

        $this->assertFalse(auth()->check());
    }
}
