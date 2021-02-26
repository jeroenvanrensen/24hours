<?php

namespace Tests\Feature\Notes;

use App\Http\Livewire\Boards\Show;
use App\Models\Board;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group notes */
class CreateNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_note()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->assertCount(0, Note::all());

        Livewire::test(Show::class, ['board' => $board])
            ->call('createNote')
            ->assertRedirect(route('notes.edit', Note::first()));

        $this->assertCount(1, Note::all());

        $this->assertDatabaseHas('notes', [
            'board_id' => $board->id,
            'title' => 'No Title',
            'body' => null
        ]);
    }

    /** @test */
    public function members_can_create_notes()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        Livewire::test(Show::class, ['board' => $board])
            ->call('createNote')
            ->assertRedirect(route('notes.edit', Note::first()));

        $this->assertCount(1, Note::all());
    }

    /** @test */
    public function viewers_cannot_create_notes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        Livewire::test(Show::class, ['board' => $board])
            ->call('createNote')
            ->assertStatus(403);

        $this->assertCount(0, Note::all());
    }
}
