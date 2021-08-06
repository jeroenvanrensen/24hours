<?php

use App\Http\Livewire\Auth\VerifyEmail;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can visit the email verification page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('verification.notice'))
        ->assertStatus(200)
        ->assertSeeLivewire('auth.verify-email');
});

test('guests cannot visit the email verification page', function () {
    $this->withExceptionHandling();
    $this->get(route('verification.notice'))->assertRedirect(route('login'));
});

test('a user can request another verify link', function () {
    Notification::fake();
    $this->actingAs($user = User::factory()->create());
    Notification::assertNothingSent();

    Livewire::test(VerifyEmail::class)->call('request');

    Notification::assertSentTo([$user], VerifyEmailNotification::class);
});

test('a user can verify their email', function () {
    $this->actingAs($user = User::factory()->create(['email_verified_at' => null]));

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(30),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    expect($user->fresh()->email_verified_at)->toBeNull();
    $this->get($verificationUrl)->assertRedirect(route('invitations.check'));
    expect($user->fresh()->email_verified_at)->not()->toBeNull();
});

test('guests cannot verify their email', function () {
    $this->withExceptionHandling();
    $user = User::factory()->create();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(30),
        ['id' => $user->id, 'hash' => sha1($user->email)]
    );

    $this->get($verificationUrl)->assertRedirect(route('login'));
});

test('the token must be valid', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create(['email_verified_at' => null]));

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(30),
        ['id' => $user->id, 'hash' => 'wrong-hash'] // wrong hash
    );

    $this->get($verificationUrl)->assertStatus(403);
    expect($user->fresh()->email_verified_at)->toBeNull();
});
