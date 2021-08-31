<?php

use App\Http\Livewire\Links\Create;
use App\Models\Board;
use App\Models\Link;
use App\Models\Membership;
use App\Models\User;
use Livewire\Livewire;

test('the board owner can add a link', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    expect(Link::all())->toHaveCount(0);

    Livewire::test(Create::class, ['board' => $board])
        ->set('url', 'https://tailwindcss.com/')
        ->call('add')
        ->assertRedirect(route('boards.show', $board));

    expect(Link::all())->toHaveCount(1);
    tap(Link::first(), function ($link) use ($board) {
        expect($link->board_id)->toBe($board->id);
        expect($link->url)->toBe('https://tailwindcss.com/');
        expect($link->title)->toBe('Tailwind CSS - Rapidly build modern websites without ever leaving your HTML.');
    });
});

test('guests cannot add a link', function () {
    $this->withExceptionHandling();
    $board = Board::factory()->create();
    Livewire::test(Create::class, ['board' => $board])->set('url', 'https://tailwindcss.com/')->call('add')->assertStatus(403);
    expect(Link::all())->toHaveCount(0);
});

test('members can add links', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();

    Livewire::test(Create::class, ['board' => $board])
        ->set('url', 'https://tailwindcss.com/')
        ->call('add')
        ->assertRedirect(route('boards.show', $board));

    expect(Link::all())->toHaveCount(1);
});

test('viewers can add links', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();

    Livewire::test(Create::class, ['board' => $board])->set('url', 'https://tailwindcss.com/')->call('add')->assertStatus(403);
    expect(Link::all())->toHaveCount(0);
});

test('other users cannot add links', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create();

    Livewire::test(Create::class, ['board' => $board])->set('url', 'https://tailwindcss.com/')->call('add')->assertStatus(403);
    expect(Link::all())->toHaveCount(0);
});

test('a user cannot add links if the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();

    Livewire::test(Create::class, ['board' => $board])->set('url', 'https://tailwindcss.com/')->call('add')->assertStatus(403);
    expect(Link::all())->toHaveCount(0);
});

it('requires a valid url', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();

    // Empty url
    Livewire::test(Create::class, ['board' => $board])
        ->set('url', null)
        ->call('add')
        ->assertHasErrors('url');

    // Invalid url
    Livewire::test(Create::class, ['board' => $board])
        ->set('url', 'invalid-url')
        ->call('add')
        ->assertHasErrors('url');
});
