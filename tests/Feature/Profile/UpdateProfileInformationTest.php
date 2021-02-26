<?php

namespace Tests\Feature\Profile;

use App\Http\Livewire\Profile\ProfileInfo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group profile */
class UpdateProfileInformationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_edit_their_profile()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertNotEquals('John Doe', $user->fresh()->name);
        $this->assertNotEquals('john@example.org', $user->fresh()->email);

        Livewire::test(ProfileInfo::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->call('update');
        
        $this->assertEquals('John Doe', $user->fresh()->name);    
        $this->assertEquals('john@example.org', $user->fresh()->email);    
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        Livewire::test(ProfileInfo::class)
            ->set('name', null)
            ->set('email', 'john@example.org')
            ->call('update')
            ->assertHasErrors('name');
    }

    /** @test */
    public function a_valid_email_is_required()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        // Empty email
        Livewire::test(ProfileInfo::class)
            ->set('name', 'John Doe')
            ->set('email', null)
            ->call('update')
            ->assertHasErrors('email');
        
        // Invalid email
        Livewire::test(ProfileInfo::class)
            ->set('name', 'John Doe')
            ->set('email', 'invalid-email')
            ->call('update')
            ->assertHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        $this->withoutExceptionHandling();
        
        User::factory()->create(['email' => 'john@example.org']);

        $user = User::factory()->create();
        $this->actingAs($user);
        
        Livewire::test(ProfileInfo::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org') // already exists
            ->call('update')
            ->assertHasErrors('email');
    }

    /** @test */
    public function the_email_can_be_the_same()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create(['email' => 'john@example.org']);
        $this->actingAs($user);
        
        Livewire::test(ProfileInfo::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org') // same email
            ->call('update')
            ->assertHasNoErrors();
    }

    /** @test */
    public function the_email_verified_column_is_set_to_null_if_the_email_changes()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $this->assertNotNull($user->fresh()->email_verified_at);
        
        Livewire::test(ProfileInfo::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org') // new email
            ->call('update');

        $this->assertNull($user->fresh()->email_verified_at);
    }

    /** @test */
    public function the_email_verified_column_is_not_set_to_null_if_the_email_does_not_change()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $this->assertNotNull($user->fresh()->email_verified_at);
        
        Livewire::test(ProfileInfo::class)
            ->set('name', 'John Doe')
            ->set('email', $user->email) // same email
            ->call('update');

        $this->assertNotNull($user->fresh()->email_verified_at);
    }
}
