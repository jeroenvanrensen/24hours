<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\Register;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_register_page()
    {
        $this->withoutExceptionHandling();
        
        $this->get(route('register'))
            ->assertStatus(200)
            ->assertSeeLivewire('auth.register');
    }

    /** @test */
    public function authenticated_users_cannot_visit_the_register_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('register'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function a_user_can_register()
    {
        $this->withoutExceptionHandling();

        $this->assertCount(0, User::all());
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertRedirect(route('invitations.check'));

        $this->assertCount(1, User::all());

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.org'
        ]);
    }

    /** @test */
    public function a_user_is_authenticated_after_registering()
    {
        $this->withoutExceptionHandling();

        $this->assertFalse(auth()->check());
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register');

        $this->assertTrue(auth()->check());
    }

    /** @test */
    public function a_user_gets_an_email_verification_link_after_registering()
    {
        $this->withoutExceptionHandling();
        
        Notification::fake();

        Notification::assertNothingSent();
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register');

        Notification::assertSentTo(
            [User::first()], VerifyEmail::class
        );
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->withoutExceptionHandling();
        
        Livewire::test(Register::class)
            ->set('name', null)
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors('name');
    }

    /** @test */
    public function a_valid_email_is_required()
    {
        $this->withoutExceptionHandling();
        
        // Empty email
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', null)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors('email');
        
        // Invalid email
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'invalid-email')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        $this->withoutExceptionHandling();
        
        User::factory()->create(['email' => 'john@example.org']);

        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org') // email already exists
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors('email');
    }

    /** @test */
    public function a_password_with_minimal_8_characters_is_required()
    {
        $this->withoutExceptionHandling();
        
        // Empty password
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', null)
            ->set('password_confirmation', null)
            ->call('register')
            ->assertHasErrors('password');
        
        // Too short password
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->call('register')
            ->assertHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->withoutExceptionHandling();
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'other-password') // wrong confirmation
            ->call('register')
            ->assertHasErrors('password');
    }
}
