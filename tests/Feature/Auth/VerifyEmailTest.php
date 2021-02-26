<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\VerifyEmail;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;
use Tests\TestCase;

/** @group auth */
class VerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_email_verification_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('verification.notice'))
            ->assertStatus(200)
            ->assertSeeLivewire('auth.verify-email');
    }

    /** @test */
    public function guests_cannot_visit_the_email_verification_page()
    {
        $this->get(route('verification.notice'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_request_another_verify_link()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        Notification::fake();

        Notification::assertNothingSent();
        
        Livewire::test(VerifyEmail::class)
            ->call('request');

        Notification::assertSentTo(
            [$user], VerifyEmailNotification::class
        );
    }

    /** @test */
    public function a_user_can_verify_their_email()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($user);
        
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->assertNull($user->fresh()->email_verified_at);

        $this->get($verificationUrl)
            ->assertRedirect(route('invitations.check'));

        $this->assertNotNull($user->fresh()->email_verified_at);
    }

    /** @test */
    public function guests_cannot_verify_their_email()
    {
        $user = User::factory()->create();
        
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->get($verificationUrl)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function the_token_has_to_be_valid()
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($user);
        
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(30),
            ['id' => $user->id, 'hash' => 'wrong-hash'] // wrong hash
        );

        $this->get($verificationUrl);

        $this->assertNull($user->fresh()->email_verified_at);
    }
}
