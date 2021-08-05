<?php

use App\Http\Livewire\Auth\ResetPassword;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;

uses()->beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can visit the reset password page', function () {
    $this->get(route('password.reset', Str::random(16)))
        ->assertStatus(200)
        ->assertSeeLivewire('auth.reset-password');
});

test('authenticated users cannot visit the reset password page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('password.reset', Str::random()))
        ->assertRedirect(RouteServiceProvider::HOME);
});

test('a user can reset their password', function () {
    $user = User::factory()->create();
    $token = Str::random(64);

    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => Hash::make($token),
        'created_at' => now()
    ]);

    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
    expect(Hash::check('new-password', $user->fresh()->password))->toBeFalse();

    Livewire::test(ResetPassword::class, ['token' => $token])
        ->set('email', $user->email)
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('update')
        ->assertHasNoErrors()
        ->assertRedirect(route('login'));

    expect(Hash::check('password', $user->fresh()->password))->toBeFalse();
    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

it('requires a valid token', function () {
    $user = User::factory()->create();

    DB::table('password_resets')->insert([
        'email' => $user->email,
        'token' => Str::random(64)
    ]);

    Livewire::test(ResetPassword::class, ['token' => Str::random(64)]) // invalid token
        ->set('email', $user->email)
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('update')
        ->assertHasErrors('email', 'This password reset token is invalid.');
});

it('requires a password of minimal 8 characters', function () {
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
});

test('the password must be confirmed', function () {
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
});
