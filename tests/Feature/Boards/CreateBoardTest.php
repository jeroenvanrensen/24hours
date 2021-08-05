<?php

use App\Http\Livewire\Boards\Create;
use App\Models\Board;
use App\Models\User;
use Livewire\Livewire;

uses()->beforeEach(fn () => $this->withoutExceptionHandling());

test('a user can create a new board', function () {
    $this->actingAs($user = User::factory()->create());
    expect(Board::all())->toHaveCount(0);

    Livewire::test(Create::class)
        ->set('name', 'My Board')
        ->call('create')
        ->assertRedirect(route('boards.show', Board::first()));

    expect(Board::all())->toHaveCount(1);
    tap(Board::first(), function ($board) use ($user) {
        expect($board->user_id)->toBe($user->id);
        expect($board->name)->toBe('My Board');
        expect($board->archived)->toBeFalse();
    });
});

it('requires a name', function () {
    $this->actingAs(User::factory()->create());

    Livewire::test(Create::class)
        ->set('name', null)
        ->call('create')
        ->assertHasErrors('name');
});
