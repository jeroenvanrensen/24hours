<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Link;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_link_has_a_url()
    {
        $this->withoutExceptionHandling();
        
        $link = Link::factory()->create([
            'url' => 'https://tailwindcss.com/'
        ]);

        $this->assertEquals('https://tailwindcss.com/', $link->url);
    }

    /** @test */
    public function a_link_has_a_title()
    {
        $this->withoutExceptionHandling();
        
        $link = Link::factory()->create([
            'title' => 'Tailwind CSS'
        ]);

        $this->assertEquals('Tailwind CSS', $link->title);
    }

    /** @test */
    public function a_link_belongs_to_a_board()
    {
        $this->withoutExceptionHandling();
        
        $board = Board::factory()->create();

        $link = Link::factory()->create([
            'board_id' => $board->id
        ]);

        $this->assertEquals($board->id, $link->board_id);

        $this->assertInstanceOf(Board::class, $link->board);
        $this->assertEquals($board->id, $link->board->id);
    }
}
