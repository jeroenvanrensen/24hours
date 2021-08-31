<?php

use App\Http\Livewire\Items\Index;
use App\Models\Board;
use App\Models\Link;
use App\Models\Membership;
use App\Models\User;
use Livewire\Livewire;

test('the board owner can delete a link', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->create();
    $link = Link::factory()->for($board)->create();
    expect($link->exists())->toBeTrue();

    Livewire::test(Index::class, ['board' => $board])
        ->call('deleteLink', $link)
        ->assertRedirect(route('boards.show', $board));

    expect($link->exists())->toBeFalse();
});

test('members can delete a link', function () {
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->member()->create();
    $link = Link::factory()->for($board)->create();
    expect($link->exists())->toBeTrue();

    Livewire::test(Index::class, ['board' => $board])
        ->call('deleteLink', $link)
        ->assertRedirect(route('boards.show', $board));

    expect($link->exists())->toBeFalse();
});

test('viewers cannot delete a link', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->create();
    Membership::factory()->for($user)->for($board)->viewer()->create();
    $link = Link::factory()->for($board)->create();

    Livewire::test(Index::class, ['board' => $board])->call('deleteLink', $link)->assertStatus(403);
    expect($link->exists())->toBeTrue();
});

test('guests cannot delete a link', function () {
    $this->withExceptionHandling();
    $board = Board::factory()->create();
    $link = Link::factory()->for($board)->create();

    Livewire::test(Index::class, ['board' => $board])->call('deleteLink', $link)->assertStatus(403);
    expect($link->exists())->toBeTrue();
});

test('other users cannot delete links', function () {
    $this->withExceptionHandling();
    $this->actingAs(User::factory()->create());
    $board = Board::factory()->create();
    $link = Link::factory()->for($board)->create();

    Livewire::test(Index::class, ['board' => $board])->call('deleteLink', $link)->assertStatus(403);
    expect($link->exists())->toBeTrue();
});

test('a user cannot delete a link if the board is archived', function () {
    $this->withExceptionHandling();
    $this->actingAs($user = User::factory()->create());
    $board = Board::factory()->for($user)->archived()->create();
    $link = Link::factory()->for($board)->create();

    Livewire::test(Index::class, ['board' => $board])->call('deleteLink', $link)->assertStatus(403);
    expect($link->exists())->toBeTrue();
});
