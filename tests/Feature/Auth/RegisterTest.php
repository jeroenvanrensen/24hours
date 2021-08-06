<?php

use App\Http\Livewire\Auth\Register;
use App\Models\Board;
use App\Models\Link;
use App\Models\Note;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can visit the register page', function () {
    $this->get(route('register'))
        ->assertStatus(200)
        ->assertSeeLivewire('auth.register');
});

test('authenticated users cannot visit the register page', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('register'))->assertRedirect(RouteServiceProvider::HOME);
});

test('a user can register', function () {
    expect(User::all())->toHaveCount(0);

    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertRedirect(route('invitations.check'));

    expect(User::all())->toHaveCount(1);
    tap(User::first(), function ($user) {
        expect($user->name)->toBe('John Doe');
        expect($user->email)->toBe('john@example.org');
        expect(Hash::check('password', $user->password))->toBeTrue();
    });

    expect(Board::all())->toHaveCount(0);
    expect(Note::all())->toHaveCount(0);
    expect(Link::all())->toHaveCount(0);
});

test('a user is authenticated after registering', function () {
    expect(auth()->check())->toBeFalse();

    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertHasNoErrors();

    expect(auth()->check())->toBeTrue();
});

test('a user gets an email verification link after registering', function () {
    Notification::fake();
    Notification::assertNothingSent();

    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertHasNoErrors();

    Notification::assertSentTo([User::first()], VerifyEmail::class);
});

it('requires a name', function () {
    Livewire::test(Register::class)
        ->set('name', null)
        ->set('email', 'john@example.org')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertHasErrors('name');
});

it('requires a valid email', function () {
    // Empty email
    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', null)
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertHasErrors('email');

    // Invalid email
    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'invalid-email')
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertHasErrors('email');
});

test('the email must be unique', function () {
    User::factory()->create(['email' => 'john@example.org']);

    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org') // email already exists
        ->set('password', 'password')
        ->set('password_confirmation', 'password')
        ->call('register')
        ->assertHasErrors('email');
});

it('requires a password of minimal 8 characters', function () {
    // Empty password
    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org')
        ->set('password', null)
        ->set('password_confirmation', null)
        ->call('register')
        ->assertHasErrors('password');

    // Too short password
    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org')
        ->set('password', 'short')
        ->set('password_confirmation', 'short')
        ->call('register')
        ->assertHasErrors('password');
});

test('the password must be confirmed', function () {
    Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.org')
        ->set('password', 'password')
        ->set('password_confirmation', 'other-password') // wrong confirmation
        ->call('register')
        ->assertHasErrors('password');
});
