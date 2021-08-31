<?php

use App\Http\Livewire\Auth\Login;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Livewire\Livewire;
use function Pest\Faker\faker;

test('a user can visit the login page', function () {
    $this->get(route('login'))
        ->assertStatus(200)
        ->assertSeeLivewire('auth.login');
});

test('authenticated users cannot visit the login page', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('login'))->assertRedirect(RouteServiceProvider::HOME);
});

test('a user can login', function () {
    $user = User::factory()->create();
    expect(auth()->check())->toBeFalse();

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('login')
        ->assertRedirect(route('invitations.check'));

    expect(auth()->check())->toBeTrue();
});

test('the email must be correct', function () {
    $user = User::factory()->create();

    Livewire::test(Login::class)
        ->set('email', faker()->email()) // wrong email
        ->set('password', 'password')
        ->call('login')
        ->assertHasErrors('email');

    expect(auth()->check())->toBeFalse();
});

test('the password must be correct', function () {
    $user = User::factory()->create();

    Livewire::test(Login::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password') // wrong password
        ->call('login')
        ->assertHasErrors('email');

    expect(auth()->check())->toBeFalse();
});
