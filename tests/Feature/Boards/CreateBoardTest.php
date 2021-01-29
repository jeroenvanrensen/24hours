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
    public function a_user_can_create_a_new_board()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertCount(0, Board::all());
        
        Livewire::test(Create::class)
            ->set('name', 'My Board')
            ->call('create')
            ->assertRedirect(route('boards.show', Board::first()));

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
