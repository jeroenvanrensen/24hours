<?php

namespace Tests\Feature\Boards;

use App\Http\Livewire\Boards\Edit;
use App\Models\Board;
use App\Models\Link;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteBoardsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_a_board()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->assertTrue($board->exists());

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        $this->assertFalse($board->exists());
    }

    /** @test */
    public function deleting_a_board_deletes_all_its_links_too()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $link = Link::factory()->for($board)->create();

        $this->assertTrue($link->exists());

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        $this->assertFalse($link->exists());
    }

    /** @test */
    public function deleting_a_board_deletes_all_its_notes_too()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertTrue($note->exists());

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        $this->assertFalse($note->exists());
    }
}
