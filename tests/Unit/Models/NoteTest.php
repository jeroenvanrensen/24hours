<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Note;
use function Pest\Faker\faker;

uses()->beforeEach(fn () => $this->withoutExceptionHandling());

it('has a title', function () {
    $title = faker()->sentence();
    $note = Note::factory()->create(['title' => $title]);
    expect($note->title)->toBe($title);
});

it('has a nullable body', function () {
    $body = faker()->paragraph();
    $note = Note::factory()->create(['body' => $body]);
    expect($note->body)->toBe($body);

    $note = Note::factory()->create(['body' => null]);
    expect($note->body)->toBeNull();
});

it('belongs to a board', function () {
    $board = Board::factory()->create();
    $note = Note::factory()->create(['board_id' => $board->id]);

    expect($note->board_id)->toBe($board->id);
    expect($note->board)->toBeInstanceOf(Board::class);
    expect($note->board->id)->toBe($board->id);
});

it('has a word count', function ($body, $wordCount) {
    $note = Note::factory()->create(['body' => $body]);
    expect($note->word_count)->toBe($wordCount);
})->with([
    ['Hello', 1],
    ['Hello world', 2],
    ['Hello world!', 2],
    ['Hello, world!', 2],
    ['A cat is: an animal', 5],
    ['A cat is : an animal', 5],
    ['<h1>Title</h1> <p>Body</p>', 2],
    ['<h1>Title</h1><p>Body</p>', 2],
    ['<h1>Hello everyone!</h1> <p>How are you?</p>', 5],
    ['<strong> bold </strong> text!', 2],
    ['<a href="google.com"> Google </a> is great', 3],
    ['{ A # sentence @ with : many & weird ) characters =', 6],

    ['Its a cat', 3],
    ['It\'s a cat', 4],
    ['it\'s a cat', 4],
    ['She\'s a girl.', 4],
    ['she\'s a girl', 4],
    ['He\'s a boy', 4],
    ['he\'s a boy.', 4],
    ['HE\'s a boy.', 4],

    ['That the user\'s name', 4],
    ['That the User\'s name', 4],

    ['I\'m', 2],
    ['I am', 2],
    ['Im', 1],
    ['i\'m', 2],
    ['I\'M', 2],

    ['You\'re', 2],
    ['You are', 2],
    ['Youre', 1],
    ['you\'re', 2],
    ['YOU\'re', 2],
    ['YOU\'RE', 2],

    ['We\'re', 2],
    ['We are', 2],
    ['Were', 1],
    ['we\'re', 2],
    ['WE\'re', 2],
    ['WE\'RE', 2],

    ['They\'re', 2],
    ['They are', 2],
    ['Theyre', 1],
    ['they\'re', 2],
    ['THEY\'re', 2],
    ['THEY\'RE', 2]
]);
