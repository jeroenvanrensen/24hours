<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Link;
use function Pest\Faker\faker;

uses()->beforeEach(fn () => $this->withoutExceptionHandling());

it('has a url', function () {
    $url = faker()->url();
    $link = Link::factory()->create(['url' => $url]);
    expect($link->url)->toBe($url);
});

it('has a title', function () {
    $title = faker()->sentence();
    $link = Link::factory()->create(['title' => $title]);
    expect($link->title)->toBe($title);
});

it('has a nullable image', function () {
    $image = faker()->imageUrl();
    $link = Link::factory()->create(['image' => $image]);
    expect($link->image)->toBe($image);

    $link = Link::factory()->create(['image' => null]);
    expect($link->image)->toBeNull();
});

it('belongs to a board', function () {
    $board = Board::factory()->create();
    $link = Link::factory()->create(['board_id' => $board->id]);

    expect($link->board_id)->toBe($board->id);
    expect($link->board)->toBeInstanceOf(Board::class);
    expect($link->board->id)->toBe($board->id);
});

it('has a host', function ($url, $host) {
    $link = Link::factory()->create(['url' => $url]);
    expect($link->host)->toBe($host);
})->with([
    ['https://tailwindcss.com/docs/guides/laravel', 'tailwindcss.com'],
    ['https://play.tailwindcss.com/SEhypX52xg', 'play.tailwindcss.com'],
    ['https://www.google.com/', 'google.com'],
    ['https://laravel.com/docs/8.x/responses', 'laravel.com']
]);
