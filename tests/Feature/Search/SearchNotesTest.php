<?php

namespace Tests\Feature\Search;

use App\Http\Livewire\Search\Search;
use App\Models\Board;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group search */
class SearchNotesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_their_notes()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $firstNote = Note::factory()->for($board)->create(['title' => 'First Note']);
        $secondNote = Note::factory()->for($board)->create(['title' => 'Second Note']);

        Livewire::test(Search::class)
            ->assertDontSee($firstNote->title)
            ->assertDontSee($secondNote->title)
            ->set('query', 'First')
            ->assertSee($firstNote->title)
            ->assertDontSee($secondNote->title);
    }

    /** @test */
    public function a_user_can_search_their_notes_by_body()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $firstNote = Note::factory()->for($board)->create(['body' => 'First Note']);
        $secondNote = Note::factory()->for($board)->create(['body' => 'Second Note']);

        Livewire::test(Search::class)
            ->assertDontSee($firstNote->title)
            ->assertDontSee($secondNote->title)
            ->set('query', 'First')
            ->assertSee($firstNote->title)
            ->assertDontSee($secondNote->title);
    }

    /** @test */
    public function a_user_cannot_see_a_note_they_dont_own()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(); // other user
        $note = Note::factory()->for($board)->create();

        Livewire::test(Search::class)   
            ->set('query', $note->title)
            ->assertDontSee($note->title);
    }

    /** @test */
    public function the_notes_are_sorted_by_date()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $firstNote = Note::factory()->for($board)->create(['title' => 'First Note', 'updated_at' => now()->subWeek()]);
        $secondNote = Note::factory()->for($board)->create(['title' => 'Second Note', 'updated_at' => now()]);

        Livewire::test(Search::class)
            ->set('query', 'Note')
            ->assertSeeInOrder([
                $secondNote->title,
                $firstNote->title
            ]);
    }
}
