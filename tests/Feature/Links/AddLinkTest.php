<?php

namespace Tests\Feature\Links;

use App\Http\Livewire\Links\Create;
use App\Models\Board;
use App\Models\Link;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AddLinkTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_add_a_link()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        
        $this->assertCount(0, Link::all());

        Livewire::test(Create::class, ['board' => $board])
            ->set('url', 'https://tailwindcss.com/')
            ->call('add');

        $this->assertCount(1, Link::all());

        $this->assertDatabaseHas('links', [
            'board_id' => $board->id,
            'url' => 'https://tailwindcss.com/',
            'title' => 'Tailwind CSS - Rapidly build modern websites without ever leaving your HTML.'
        ]);
    }

    /** @test */
    public function a_link_requires_a_valid_url()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        // Empty url
        Livewire::test(Create::class, ['board' => $board])
            ->set('url', null)
            ->call('add')
            ->assertHasErrors('url');

        // Invalid url
        Livewire::test(Create::class, ['board' => $board])
            ->set('url', 'invalid-url')
            ->call('add')
            ->assertHasErrors('url');
    }
}
