<?php

use App\Http\Livewire\Auth\RequestPasswordLink;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

test('a user can visit the request password page', function () {
    $this->get(route('password.request'))
        ->assertStatus(200)
        ->assertSeeLivewire('auth.request-password-link');
});

test('authenticated users cannot visit the request password page', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('password.request'))->assertRedirect(RouteServiceProvider::HOME);
});

test('a user can request a new password', function () {
    Notification::fake();
    $user = User::factory()->create();
    $this->assertDatabaseCount('password_resets', 0);

    Livewire::test(RequestPasswordLink::class)
        ->set('email', $user->email)
        ->call('request')
        ->assertHasNoErrors();

    Notification::assertSentTo($user, ResetPassword::class);
    $this->assertDatabaseCount('password_resets', 1);
    $this->assertDatabaseHas('password_resets', ['email' => $user->email]);
});

test('the email has to exist', function () {
    Livewire::test(RequestPasswordLink::class)
        ->set('email', 'john@example.org') // email does not exist
        ->call('request')
        ->assertHasErrors('email');
});
