<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @group models */
class NoteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_note_has_a_title()
    {
        $this->withoutExceptionHandling();
        
        $note = Note::factory()->create([
            'title' => 'Note Title'
        ]);

        $this->assertEquals('Note Title', $note->title);
    }

    /** @test */
    public function a_note_has_a_nullable_body()
    {
        $this->withoutExceptionHandling();
        
        $note = Note::factory()->create([
            'body' => 'Note Body'
        ]);

        $this->assertEquals('Note Body', $note->body);
        
        $note = Note::factory()->create([
            'body' => null
        ]);

        $this->assertNull($note->body);
    }

    /** @test */
    public function a_note_belongs_to_a_board()
    {
        $this->withoutExceptionHandling();
        
        $board = Board::factory()->create();

        $note = Note::factory()->create([
            'board_id' => $board->id
        ]);

        $this->assertEquals($board->id, $note->board_id);

        $this->assertInstanceOf(Board::class, $note->board);
        $this->assertEquals($board->id, $note->board->id);
    }

    /** 
     * @test
     * @dataProvider notesProvider
     */
    public function a_note_has_a_word_count($body, $expectedWordCount)
    {
        $this->withoutExceptionHandling();
        
        $note = Note::factory()->create([
            'body' => $body
        ]);

        $this->assertEquals($expectedWordCount, $note->word_count);
    }

    public function notesProvider()
    {
        return [
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
        ];
    }
}
