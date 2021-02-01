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
    public function the_updated_at_column_is_updated_after_editing_a_note()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create(['updated_at' => now()->subWeek()]);

        // Assert that the note was last updated longer than 60 seconds ago
        $this->assertTrue($note->fresh()->updated_at->diffInSeconds() > 60);

        $this->get(route('notes.edit', $note))
            ->assertStatus(200)
            ->assertSeeLivewire('notes.edit');

        // Assert that the note was last updated between now and 60 seconds ago
        $this->assertTrue($note->fresh()->updated_at->diffInSeconds() < 60);
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

    /** 
     * @test
     * @dataProvider titlesProvider
     */
    public function the_title_is_automatically_updated($body, $title)
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertNotEquals($title, $note->fresh()->title);

        Livewire::test(Edit::class, ['note' => $note])
            ->set('body', $body);

        $this->assertEquals($title, $note->fresh()->title);
    }

    public function titlesProvider()
    {
        return [
            ['My Note', 'My Note'],
            [null, 'No Title'],
            ['', 'No Title'],
            ['<h1>My Note</h1>', 'My Note'],
            ['<h1></h1>', 'No Title'],
            ['<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis optio laudantium deserunt ipsa quod explicabo nam soluta, perferendis recusandae aliquid eos illum eum, minima rem aspernatur nemo repellendus quisquam reiciendis dolorem accusamus dolor dicta saepe, eveniet voluptates? Repellendus aperiam amet enim commodi minima cumque temporibus expedita autem ipsa eaque illo esse, nisi aliquid officiis ullam voluptatem laborum quos earum placeat mollitia nobis! Autem fuga repellat ut quae quasi eum reprehenderit soluta expedita, et eaque debitis odit totam porro accusamus saepe ex dignissimos aut laboriosam aliquam amet quis. Nisi beatae aspernatur qui adipisci suscipit eligendi architecto aut atque incidunt natus, facere alias ad eaque dicta quidem placeat! Perferendis obcaecati recusandae officia veniam optio asperiores numquam sequi earum deleniti nemo mollitia voluptate pariatur et qui quisquam exercitationem fugiat, provident esse quo aspernatur, ad porro! Reprehenderit voluptatibus possimus nostrum? Nesciunt iusto a voluptatum optio nihil. Quibusdam, saepe ad fugiat aliquam quod iure quae doloremque placeat velit, dolores possimus quo nulla mollitia sapiente ducimus. Unde magni numquam saepe corporis, vitae eos accusantium, nisi fuga labore reprehenderit animi, recusandae vel enim impedit! Eligendi, veniam voluptates? Quo laudantium qui rerum molestias, placeat tempora natus, soluta itaque expedita eligendi doloremque dolor velit ratione voluptate at laborum reprehenderit odio libero earum quasi dolores blanditiis. Dolor amet cupiditate, odio perspiciatis nostrum fugiat fuga accusamus obcaecati quibusdam, ipsa sint illum odit accusantium officiis quod saepe velit explicabo nisi illo officia. Architecto quibusdam voluptate eligendi molestias? Quidem beatae rerum, quas saepe maiores rem porro deserunt incidunt. Sapiente rerum aperiam assumenda est porro labore numquam, nisi iusto doloremque accusamus, odit reprehenderit deserunt? Nihil velit quia at blanditiis ipsam amet aspernatur dolorem debitis et reiciendis illo magni possimus, unde asperiores impedit. Doloribus, omnis vero. Officiis quo voluptatem asperiores temporibus qui odio consequuntur accusantium pariatur est nihil. Veritatis ipsum saepe doloremque ipsa iusto. Libero.</p>', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Debitis optio laudantium deserunt ipsa quod explicabo nam soluta, perferendis recusandae aliquid eos illum eum, minima rem aspernatur nemo repellendus quisquam reiciendis dolorem accusamus dolor'],
            [$this->getBreakNote(), 'My Note']
        ];
    }

    protected function getBreakNote(): string
    {
        return '<h1>My Note</h1>
        <p>Note Content</p>';
    }
}
