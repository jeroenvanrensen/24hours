<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\ResetPassword;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_reset_password_page()
    {
        $this->withoutExceptionHandling();
        
        $this->get(route('password.reset', Str::random()))
            ->assertStatus(200)
            ->assertSeeLivewire('auth.reset-password');
    }

    /** @test */
    public function authenticated_users_cannot_visit_the_reset_password_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('password.reset', Str::random()))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function a_user_can_reset_their_password()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $oldPassword = $user->password;

        $token = Str::random(64);
        
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Hash::make($token),
            'created_at' => now()
        ]);

        $this->assertEquals($oldPassword, $user->fresh()->password);

        Livewire::test(ResetPassword::class, ['token' => $token])
            ->set('email', $user->email)
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('update')
            ->assertHasNoErrors()
            ->assertRedirect(route('login'));

        $this->assertNotEquals($oldPassword, $user->fresh()->password);
    }

    /** @test */
    public function a_valid_token_is_required()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => 'token'
        ]);

        Livewire::test(ResetPassword::class, ['token' => Str::random(64)]) // invalid token
            ->set('email', $user->email)
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('update')
            ->assertHasErrors('email', 'This password reset token is invalid.');
    }

    /** @test */
    public function a_password_is_required_and_must_be_at_least_8_characters()
    {
        $token = Str::random();

        DB::table('password_resets')->insert([
            'email' => 'john@example.org',
            'token' => $token
        ]);

        // Empty password
        Livewire::test(ResetPassword::class, ['token' => $token])
            ->set('email', 'john@example.org')
            ->set('password', null)
            ->set('password_confirmation', null)
            ->call('update')
            ->assertHasErrors('password');

        // Too short password
        Livewire::test(ResetPassword::class, ['token' => $token])
            ->set('email', 'john@example.org')
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->call('update')
            ->assertHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $token = Str::random();

        DB::table('password_resets')->insert([
            'email' => 'john@example.org',
            'token' => $token
        ]);

        Livewire::test(ResetPassword::class, ['token' => $token])
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'wrong-confirmation') // confirmation does not match
            ->call('update')
            ->assertHasErrors('password');
    }
}
