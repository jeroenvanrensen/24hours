<?php

namespace Tests\Feature\Notes;

use App\Http\Livewire\Notes\Edit;
use App\Models\Board;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EditNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_notes_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->get(route('notes.edit', $note))
            ->assertStatus(200)
            ->assertSeeLivewire('notes.edit');
    }

    /** @test */
    public function guests_cannot_visit_the_notes_page()
    {
        $note = Note::factory()->create();

        $this->get(route('notes.edit', $note))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function non_owners_cannot_visit_the_notes_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(); // other user
        $note = Note::factory()->for($board)->create();

        $this->get(route('notes.edit', $note))
            ->assertStatus(403);
    }

    /** @test */
    public function a_user_can_edit_a_note()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertNotEquals('My Note', $note->fresh()->body);

        Livewire::test(Edit::class, ['note' => $note])
            ->set('body', 'My Note');

        $this->assertEquals('My Note', $note->fresh()->body);
    }

    /** @test */
    public function the_title_is_automatically_updated()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertNotEquals('My Note', $note->fresh()->title);

        Livewire::test(Edit::class, ['note' => $note])
            ->set('body', 'My Note');

        $this->assertEquals('My Note', $note->fresh()->title);
    }

    /** @test */
    public function the_title_is_no_title_if_the_body_is_empty()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertNotEquals('No Title', $note->fresh()->title);

        Livewire::test(Edit::class, ['note' => $note])
            ->set('body', '');

        $this->assertEquals('No Title', $note->fresh()->title);
    }
}
