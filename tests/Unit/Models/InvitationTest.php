<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Invitation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_invitation_has_an_email()
    {
        $this->withoutExceptionHandling();
        
        $invitation = Invitation::factory()->create([
            'email' => 'john@example.org'
        ]);

        $this->assertEquals('john@example.org', $invitation->email);
    }

    /** @test */
    public function an_invitation_has_a_role()
    {
        $this->withoutExceptionHandling();
        
        $invitation = Invitation::factory()->create([
            'role' => 'member'
        ]);

        $this->assertEquals('member', $invitation->role);
    }

    /** @test */
    public function an_invitation_belongs_to_a_board()
    {
        $this->withoutExceptionHandling();
        
        $board = Board::factory()->create();

        $invitation = Invitation::factory()->create([
            'board_id' => $board->id
        ]);

        $this->assertEquals($board->id, $invitation->board_id);

        $this->assertInstanceOf(Board::class, $invitation->board);
        $this->assertEquals($board->id, $invitation->board->id);
    }
}
