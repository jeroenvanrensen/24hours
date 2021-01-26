<?php

namespace Tests\Unit;

use App\Models\Board;
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
}
