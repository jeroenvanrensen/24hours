<?php

namespace Tests\Feature\Boards;

use App\Http\Livewire\Boards\Show;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ArchiveBoardsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function the_board_owner_can_archive_the_board()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->assertFalse($board->fresh()->archived);

        Livewire::test(Show::class, ['board' => $board])
            ->call('archive')
            ->assertRedirect(route('boards.show', $board));

        $this->assertTrue($board->fresh()->archived);
    }

    /** @test */
    public function board_members_cannot_archive_the_board()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        Livewire::test(Show::class, ['board' => $board])
            ->call('archive')
            ->assertStatus(403);

        $this->assertFalse($board->fresh()->archived);
    }

    /** @test */
    public function board_viewers_cannot_archive_the_board()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        Livewire::test(Show::class, ['board' => $board])
            ->call('archive')
            ->assertStatus(403);

        $this->assertFalse($board->fresh()->archived);
    }

    /** @test */
    public function the_board_owner_can_unarchive_the_board()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create(['archived' => true]);

        $this->assertTrue($board->fresh()->archived);

        Livewire::test(Show::class, ['board' => $board])
            ->call('unarchive')
            ->assertRedirect(route('boards.show', $board));

        $this->assertFalse($board->fresh()->archived);
    }

    /** @test */
    public function board_members_cannot_unarchive_the_board()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(['archived' => true]);
        Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        Livewire::test(Show::class, ['board' => $board])
            ->call('unarchive')
            ->assertStatus(403);

        $this->assertTrue($board->fresh()->archived);
    }

    /** @test */
    public function board_viewers_cannot_unarchive_the_board()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create(['archived' => true]);
        Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        Livewire::test(Show::class, ['board' => $board])
            ->call('unarchive')
            ->assertStatus(403);

        $this->assertTrue($board->fresh()->archived);
    }
}
