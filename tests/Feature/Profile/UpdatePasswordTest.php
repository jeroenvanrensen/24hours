<?php

namespace Tests\Feature\Profile;

use App\Http\Livewire\Profile\Password;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group profile */
class UpdatePasswordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_update_their_password()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', /* password */]);
        $this->actingAs($user);

        $this->assertEquals('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', $user->fresh()->password);
        
        Livewire::test(Password::class)
            ->set('old_password', 'password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('update');

        $this->assertNotEquals('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', $user->fresh()->password);
    }

    /** @test */
    public function the_old_password_has_to_be_correct()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', /* password */]);
        $this->actingAs($user);
        
        Livewire::test(Password::class)
            ->set('old_password', 'wrong-old-password') // wrong old password
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('update')
            ->assertHasErrors('old_password');
    }

    /** @test */
    public function the_new_password_must_be_at_least_8_characters()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', /* password */]);
        $this->actingAs($user);
        
        Livewire::test(Password::class)
            ->set('old_password', 'password')
            ->set('password', 'short') // too short password
            ->set('password_confirmation', 'short')
            ->call('update')
            ->assertHasErrors('password');
    }

    /** @test */
    public function the_new_password_must_be_confirmed()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', /* password */]);
        $this->actingAs($user);
        
        Livewire::test(Password::class)
            ->set('old_password', 'password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'wrong-confirmation') // wrong confirmation
            ->call('update')
            ->assertHasErrors('password');
    }
}
