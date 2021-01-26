<?php

namespace Tests\Feature;

use App\Http\Livewire\Layouts\Navbar;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NavbarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_logout()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertTrue(auth()->check());
        
        Livewire::test(Navbar::class)
            ->call('logout')
            ->assertRedirect(url('/'));

        $this->assertFalse(auth()->check());
    }
}
