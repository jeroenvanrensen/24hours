<?php

namespace Tests\Unit\Models;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_name()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create([
            'name' => 'John Doe'
        ]);

        $this->assertEquals('John Doe', $user->name);
    }

    /** @test */
    public function a_user_has_a_unique_email()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create([
            'email' => 'john@example.org'
        ]);

        $this->assertEquals('john@example.org', $user->email);

        $this->expectException(QueryException::class);
        
        User::factory()->create([
            'email' => 'john@example.org' // same email
        ]);
    }

    /** @test */
    public function a_user_has_a_nullable_email_verified_at_column()
    {
        $this->withoutExceptionHandling();

        $today = today();
        
        $user = User::factory()->create([
            'email_verified_at' => $today
        ]);

        $this->assertEquals($today, $user->email_verified_at);
        
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);

        $this->assertNull($user->email_verified_at);
    }

    /** @test */
    public function a_user_has_a_password()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create([
            'password' => 'password'
        ]);

        $this->assertEquals('password', $user->password);
    }

    /** @test */
    public function a_user_has_a_nullable_remember_token_column()
    {
        $this->withoutExceptionHandling();

        $today = today();
        
        $user = User::factory()->create([
            'remember_token' => $today
        ]);

        $this->assertEquals($today, $user->remember_token);
        
        $user = User::factory()->create([
            'remember_token' => null
        ]);

        $this->assertNull($user->remember_token);
    }
}
