<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
}
