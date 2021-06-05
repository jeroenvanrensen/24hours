<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Invitation;
use App\Models\Link;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @group models */
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
    public function a_board_is_archived()
    {
        $this->withoutExceptionHandling();

        $board = Board::factory()->create([
            'archived' => true
        ]);

        $this->assertTrue($board->fresh()->archived);

        $board = Board::factory()->create([
            'archived' => false
        ]);

        $this->assertFalse($board->fresh()->archived);
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

    /** @test */
    public function a_board_has_many_items()
    {
        $this->withoutExceptionHandling();

        $board = Board::factory()->create();

        $link = Link::factory()->for($board)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertCount(2, $board->items);

        $this->assertInstanceOf(Note::class, $board->items[0]);
        $this->assertEquals($note->id, $board->items[0]->id);

        $this->assertInstanceOf(Link::class, $board->items[1]);
        $this->assertEquals($link->id, $board->items[1]->id);
    }

    /** @test */
    public function a_board_has_many_invitations()
    {
        $this->withoutExceptionHandling();

        $board = Board::factory()->create();

        $invitation = Invitation::factory()->for($board)->create();

        $this->assertCount(1, $board->invitations);
        $this->assertInstanceOf(Invitation::class, $board->invitations[0]);
        $this->assertEquals($invitation->id, $board->invitations[0]->id);
    }

    /** @test */
    public function a_board_has_many_memberships()
    {
        $this->withoutExceptionHandling();

        $board = Board::factory()->create();

        $membership = Membership::factory()->for($board)->create();

        $this->assertCount(1, $board->memberships);
        $this->assertInstanceOf(Membership::class, $board->memberships[0]);
        $this->assertEquals($membership->id, $board->memberships[0]->id);
    }

    /** @test */
    public function a_board_can_be_archived_and_unarchived()
    {
        $this->withoutExceptionHandling();

        $board = Board::factory()->create(['archived' => false]);

        $this->assertFalse($board->fresh()->archived);

        $board->archive();

        $this->assertTrue($board->fresh()->archived);

        $board->unarchive();

        $this->assertFalse($board->fresh()->archived);
    }
}
