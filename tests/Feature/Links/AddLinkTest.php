<?php

namespace Tests\Feature\Links;

use App\Http\Livewire\Links\Create;
use App\Models\Board;
use App\Models\Link;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group links */
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
            ->call('add')
            ->assertRedirect(route('boards.show', $board));

        $this->assertCount(1, Link::all());

        $this->assertDatabaseHas('links', [
            'board_id' => $board->id,
            'url' => 'https://tailwindcss.com/',
            'title' => 'Tailwind CSS - Rapidly build modern websites without ever leaving your HTML.'
        ]);
    }

    /** @test */
    public function guests_cannot_add_links()
    {
        $board = Board::factory()->create();

        Livewire::test(Create::class, ['board' => $board])
            ->set('url', 'https://tailwindcss.com/')
            ->call('add')
            ->assertStatus(403);
        
        $this->assertCount(0, Link::all());
    }
    
    /** @test */
    public function members_can_add_links()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        Livewire::test(Create::class, ['board' => $board])
            ->set('url', 'https://tailwindcss.com/')
            ->call('add')
            ->assertRedirect(route('boards.show', $board));
            
        $this->assertCount(1, Link::all());
    }
    
    /** @test */
    public function viewers_cannot_add_links()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        Livewire::test(Create::class, ['board' => $board])
            ->set('url', 'https://tailwindcss.com/')
            ->call('add')
            ->assertStatus(403);
            
        $this->assertCount(0, Link::all());
    }

    /** @test */
    public function other_users_cannot_add_links()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();

        Livewire::test(Create::class, ['board' => $board])
            ->set('url', 'https://tailwindcss.com/')
            ->call('add')
            ->assertStatus(403);
            
        $this->assertCount(0, Link::all());
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
