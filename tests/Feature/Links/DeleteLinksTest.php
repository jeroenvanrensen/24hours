<?php

namespace Tests\Feature\Links;

use App\Http\Livewire\Items\Index;
use App\Models\Board;
use App\Models\Link;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group links */
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

    /** @test */
    public function members_can_delete_links()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);
        $link = Link::factory()->for($board)->create();

        $this->assertTrue($link->exists());

        Livewire::test(Index::class, ['board' => $board])
            ->call('deleteLink', $link)
            ->assertRedirect(route('boards.show', $board));
        
        $this->assertFalse($link->exists());
    }

    /** @test */
    public function viewers_cannot_delete_links()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);
        $link = Link::factory()->for($board)->create();

        Livewire::test(Index::class, ['board' => $board])
            ->call('deleteLink', $link)
            ->assertStatus(403);

        $this->assertTrue($link->exists());
    }

    /** @test */
    public function guests_cannot_delete_links()
    {
        $board = Board::factory()->create();
        $link = Link::factory()->for($board)->create();

        Livewire::test(Index::class, ['board' => $board])
            ->call('deleteLink', $link)
            ->assertStatus(403);

        $this->assertTrue($link->exists());
    }

    /** @test */
    public function other_users_cannot_delete_links()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $link = Link::factory()->for($board)->create();

        Livewire::test(Index::class, ['board' => $board])
            ->call('deleteLink', $link)
            ->assertStatus(403);

        $this->assertTrue($link->exists());
    }
}
