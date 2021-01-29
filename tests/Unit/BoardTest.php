<?php

namespace Tests\Unit;

use App\Models\Board;
use App\Models\Link;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_board_has_a_name()
    {
        $this->withoutExceptionHandling();
        
        $board = Board::factory()->create([
            'name' => 'My Board'
        ]);

        $this->assertEquals('My Board', $board->name);
    }

    /** @test */
    public function a_board_belongs_to_a_user()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $board = Board::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertEquals($user->id, $board->user_id);

        $this->assertInstanceOf(User::class, $board->user);
        $this->assertEquals($user->id, $board->user->id);
    }

    /** @test */
    public function a_board_has_many_links()
    {
        $this->withoutExceptionHandling();
        
        $board = Board::factory()->create();

        $link = Link::factory()->for($board)->create();

        $this->assertCount(1, $board->links);
        $this->assertInstanceOf(Link::class, $board->links[0]);
        $this->assertEquals($link->id, $board->links[0]->id);
    }

    /** @test */
    public function a_board_has_many_notes()
    {
        $this->withoutExceptionHandling();
        
        $board = Board::factory()->create();

        $note = Note::factory()->for($board)->create();

        $this->assertCount(1, $board->notes);
        $this->assertInstanceOf(Note::class, $board->notes[0]);
        $this->assertEquals($note->id, $board->notes[0]->id);
    }
}
