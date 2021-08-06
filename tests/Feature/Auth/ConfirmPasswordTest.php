<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\ConfirmPassword;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can visit the confirm password page', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('password.confirm'))
        ->assertStatus(200)
        ->assertSeeLivewire('auth.confirm-password');
});

test('guests cannot visit the confirm password page', function () {
    $this->withExceptionHandling();
    $this->get(route('password.confirm'))->assertRedirect(route('login'));
});

test('a user can confirm their password', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(ConfirmPassword::class)
        ->set('password', 'password')
        ->call('confirm')
        ->assertHasNoErrors()
        ->assertRedirect();
});

test('the password must be correct', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(ConfirmPassword::class)
        ->set('password', 'wrong-password') // wrong password
        ->call('confirm')
        ->assertHasErrors('password');
});
