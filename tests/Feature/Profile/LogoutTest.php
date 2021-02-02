<?php

namespace Tests\Feature\Profile;

use App\Http\Livewire\Profile\Edit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_logout()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertTrue(auth()->check());

        Livewire::test(Edit::class)
            ->call('logout')
            ->assertRedirect(route('login'));

        $this->assertFalse(auth()->check());
    }
}
