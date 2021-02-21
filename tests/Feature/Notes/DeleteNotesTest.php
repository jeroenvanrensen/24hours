<?php

namespace Tests\Feature\Notes;

use App\Http\Livewire\Items\Index;
use App\Http\Livewire\Notes\Edit;
use App\Models\Board;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_a_note_from_the_edit_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertTrue($note->exists());

        Livewire::test(Edit::class, ['note' => $note])
            ->call('destroy')
            ->assertRedirect(route('boards.show', $board));
        
        $this->assertFalse($note->exists());
    }

    /** @test */
    public function members_can_delete_notes_from_the_edit_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);
        $note = Note::factory()->for($board)->create();

        $this->assertTrue($note->exists());

        Livewire::test(Edit::class, ['note' => $note])
            ->call('destroy')
            ->assertRedirect(route('boards.show', $board));
        
        $this->assertFalse($note->exists());
    }

    /** @test */
    public function viewers_cannot_delete_notes_from_the_edit_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);
        $note = Note::factory()->for($board)->create();

        Livewire::test(Edit::class, ['note' => $note])
            ->call('destroy')
            ->assertStatus(403);
        
        $this->assertTrue($note->exists());
    }
    
    /** @test */
    public function a_user_can_delete_a_note_from_the_board_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertTrue($note->exists());

        Livewire::test(Index::class, ['board' => $board])
            ->call('deleteNote', $note)
            ->assertRedirect(route('boards.show', $board));
        
        $this->assertFalse($note->exists());
    }

    /** @test */
    public function members_can_delete_notes_from_the_board_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);
        $note = Note::factory()->for($board)->create();

        $this->assertTrue($note->exists());

        Livewire::test(Index::class, ['board' => $board])
            ->call('deleteNote', $note)
            ->assertRedirect(route('boards.show', $board));
        
        $this->assertFalse($note->exists());
    }

    /** @test */
    public function viewers_cannot_delete_notes_from_the_board_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);
        $note = Note::factory()->for($board)->create();

        Livewire::test(Index::class, ['board' => $board])
            ->call('deleteNote', $note)
            ->assertStatus(403);

        $this->assertTrue($note->exists());
    }
}
