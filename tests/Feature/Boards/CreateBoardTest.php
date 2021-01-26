<?php

namespace Tests\Feature\Boards;

use App\Http\Livewire\Boards\Create;
use App\Models\Board;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CreateBoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_create_new_board_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->get(route('boards.create'))
            ->assertStatus(200)
            ->assertSeeLivewire('boards.create');
    }

    /** @test */
    public function guests_cannot_visit_the_create_new_board_page()
    {
        $this->get(route('boards.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function a_user_can_create_a_new_board()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertCount(0, Board::all());
        
        Livewire::test(Create::class)
            ->set('name', 'My Board')
            ->call('create')
            ->assertRedirect(route('boards.index'));

        $this->assertCount(1, Board::all());

        $this->assertDatabaseHas('boards', [
            'user_id' => $user->id,
            'name' => 'My Board'
        ]);
    }

    /** @test */
    public function a_board_requires_a_name()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(Create::class)
            ->set('name', null)
            ->call('create')
            ->assertHasErrors('name');
    }
}
