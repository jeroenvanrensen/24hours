<?php

use App\Http\Livewire\Profile\Delete;
use App\Models\Board;
use App\Models\Link;
use App\Models\Note;
use App\Models\User;
use Livewire\Livewire;

test('a user can visit the delete account page', function () {
    $this->actingAs(User::factory()->create());
    $this->get(route('profile.delete'))->assertStatus(200)->assertSeeLivewire('profile.delete');
});

test('guests cannot visit the delete account page', function () {
    $this->withExceptionHandling();
    $this->get(route('profile.delete'))->assertRedirect(route('login'));
});

test('a user can delete their account', function () {
    $this->actingAs($user = User::factory()->create());
    expect($user->exists())->toBeTrue();

    Livewire::test(Delete::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('destroy')
        ->assertRedirect(route('home'));

    expect($user->exists())->toBeFalse();
});

test('the email must be correct', function () {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(Delete::class)
        ->set('email', 'wrong-email')
        ->set('password', 'password')
        ->call('destroy')
        ->assertHasErrors('email')
        ->assertSet('password', '');
});

test('the password must be correct', function () {
    $this->actingAs($user = User::factory()->create());

    Livewire::test(Delete::class)
        ->set('email', $user->email)
        ->set('password', 'wrong-password')
        ->call('destroy')
        ->assertHasErrors('email')
        ->assertSet('password', '');

    expect($user->exists())->toBeTrue();
});

test('all the users boards are deleted', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    expect($board->exists())->toBeTrue();

    Livewire::test(Delete::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('destroy');

    expect($board->exists())->toBeFalse();
});

test('all users links are deleted', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $link = Link::factory()->for($board)->create();

    expect($link->exists())->toBeTrue();

    Livewire::test(Delete::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('destroy');

    expect($link->exists())->toBeFalse();
});

test('all users notes are deleted', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $note = Note::factory()->for($board)->create();

    expect($note->exists())->toBeTrue();

    Livewire::test(Delete::class)
        ->set('email', $user->email)
        ->set('password', 'password')
        ->call('destroy');

    expect($note->exists())->toBeFalse();
});
