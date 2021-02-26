<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\ConfirmPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group auth */
class ConfirmPasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_confirm_password_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('password.confirm'))
            ->assertStatus(200)
            ->assertSeeLivewire('auth.confirm-password');
    }

    /** @test */
    public function guests_cannot_visit_the_confirm_password_page()
    {
        $this->get(route('password.confirm'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_confirm_their_password()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create([
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
        ]);
        $this->actingAs($user);

        Livewire::test(ConfirmPassword::class)
            ->set('password', 'password')
            ->call('confirm')
            ->assertHasNoErrors()
            ->assertRedirect();
    }

    /** @test */
    public function the_password_has_to_be_correct()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create([
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' // password
        ]);
        $this->actingAs($user);

        Livewire::test(ConfirmPassword::class)
            ->set('password', 'wrong-password') // wrong password
            ->call('confirm')
            ->assertHasErrors('password');
    }
}
