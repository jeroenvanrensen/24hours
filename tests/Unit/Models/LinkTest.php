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
    public function a_link_has_a_nullable_image()
    {
        $this->withoutExceptionHandling();
        
        $link = Link::factory()->create([
            'image' => 'https://refactoringui.nyc3.cdn.digitaloceanspaces.com/tailwind-logo.svg'
        ]);

        $this->assertEquals('https://refactoringui.nyc3.cdn.digitaloceanspaces.com/tailwind-logo.svg', $link->image);

        $link = Link::factory()->create([
            'image' => null
        ]);

        $this->assertNull($link->image);
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

    /** @test */
    public function a_link_has_a_host()
    {
        $this->withoutExceptionHandling();
        
        $link = Link::factory()->create([
            'url' => 'https://tailwindcss.com/docs/guides/laravel'
        ]);

        $this->assertEquals('tailwindcss.com', $link->host);
        
        $link = Link::factory()->create([
            'url' => 'https://play.tailwindcss.com/SEhypX52xg'
        ]);

        $this->assertEquals('play.tailwindcss.com', $link->host);
        
        $link = Link::factory()->create([
            'url' => 'https://www.google.com/'
        ]);

        $this->assertEquals('google.com', $link->host);
    }
}
