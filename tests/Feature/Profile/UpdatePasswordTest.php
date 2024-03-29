<?php

use App\Http\Livewire\Profile\Password;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

test('a user can visit the update password page', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('profile.password'))->assertStatus(200)->assertSeeLivewire('profile.password');
});

test('guests cannot visit the update password page', function () {
    $this->withExceptionHandling();
    $this->get(route('profile.password'))->assertRedirect(route('login'));
});

test('a user can update their password', function () {
    $this->actingAs($user = User::factory()->create());
    expect(Hash::check('new-password', $user->fresh()->password))->toBeFalse();

    Livewire::test(Password::class)
        ->set('old_password', 'password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('update');

    expect(Hash::check('new-password', $user->fresh()->password))->toBeTrue();
});

test('the old password must be correct', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Password::class)
        ->set('old_password', 'wrong-old-password') // wrong old password
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('update')
        ->assertHasErrors('old_password');
});

test('the new password must be at least 8 characters', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Password::class)
        ->set('old_password', 'password')
        ->set('password', 'short') // too short password
        ->set('password_confirmation', 'short')
        ->call('update')
        ->assertHasErrors('password');
});

test('the new password must be confirmed', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Password::class)
        ->set('old_password', 'password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'wrong-confirmation') // wrong confirmation
        ->call('update')
        ->assertHasErrors('password');
});
