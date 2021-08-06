<?php

use App\Http\Livewire\Profile\ProfileInfo;
use App\Models\User;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can edit their profile', function () {
    $this->actingAs($user = User::factory()->create());
    expect($user->fresh()->name)->not()->toBe('John Doe');
    expect($user->fresh()->email)->not()->toBe('john@example.org');

    Livewire::test(ProfileInfo::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org')
        ->call('update');

    expect($user->fresh()->name)->toBe('John Doe');
    expect($user->fresh()->email)->toBe('john@example.org');
});

it('requires a name', function () {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(ProfileInfo::class)
        ->set('name', null)
        ->set('email', 'john@example.org')
        ->call('update')
        ->assertHasErrors('name');
});

it('requires a vaild email', function () {
    $this->actingAs($user = User::factory()->create());

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
});

test('the email must be unique', function () {
    User::factory()->create(['email' => 'john@example.org']);
    $this->actingAs($user = User::factory()->create());

    Livewire::test(ProfileInfo::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org') // already exists
        ->call('update')
        ->assertHasErrors('email');
});

test('the email can stay the same', function () {
    $this->actingAs(User::factory()->create(['email' => 'john@example.org']));

    Livewire::test(ProfileInfo::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org') // same email
        ->call('update')
        ->assertHasNoErrors();
});

test('the email_verified_at column is set to null when the email changes', function () {
    $this->actingAs($user = User::factory()->create());
    expect($user->fresh()->email_verified_at)->not()->toBeNull();

    Livewire::test(ProfileInfo::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org') // new email
        ->call('update');

    expect($user->fresh()->email_verified_at)->toBeNull();
});

test('the email_verified_at column is not set to null when the email stays the same', function () {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(ProfileInfo::class)
        ->set('name', 'John Doe')
        ->set('email', $user->email) // new email
        ->call('update');

    expect($user->fresh()->email_verified_at)->not()->toBeNull();
});
