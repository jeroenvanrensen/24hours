<?php

namespace Tests\Feature\Links;

use App\Http\Livewire\Items\Index;
use App\Models\Board;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteLinksTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function a_user_can_delete_a_link()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $link = Link::factory()->for($board)->create();

        $this->assertTrue($link->exists());

        Livewire::test(Index::class, ['board' => $board])
            ->call('deleteLink', $link)
            ->assertRedirect(route('boards.show', $board));
        
        $this->assertFalse($link->exists());
    }
}
