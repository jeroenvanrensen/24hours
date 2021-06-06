<?php

namespace Tests\Feature\Boards;

use App\Http\Livewire\Boards\Show;
use App\Mail\BoardArchivedMail;
use App\Mail\BoardUnarchivedMail;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
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
    public function the_board_owner_does_not_get_notified_when_the_board_is_archived()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        Livewire::test(Show::class, ['board' => $board])
            ->call('archive');

        Mail::assertNothingQueued();
    }

    /** @test */
    public function all_members_get_notified_when_the_board_is_archived()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $member = User::factory()->create();
        Membership::factory()->for($member)->for($board)->create(['role' => 'member']);

        Mail::assertNothingQueued();

        Livewire::test(Show::class, ['board' => $board])
            ->call('archive');

        Mail::assertQueued(BoardArchivedMail::class, function(BoardArchivedMail $mail) use ($member) {
            return $mail->hasTo($member->email);
        });
    }

    /** @test */
    public function board_viewers_get_notified_when_the_board_is_archived()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $viewer = User::factory()->create();
        Membership::factory()->for($viewer)->for($board)->create(['role' => 'viewer']);

        Mail::assertNothingQueued();

        Livewire::test(Show::class, ['board' => $board])
            ->call('archive');

        Mail::assertQueued(BoardArchivedMail::class, function(BoardArchivedMail $mail) use ($viewer) {
            return $mail->hasTo($viewer->email);
        });
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

    /** @test */
    public function the_board_owner_does_not_get_notified_when_the_board_is_unarchived()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create(['archived' => true]);

        Livewire::test(Show::class, ['board' => $board])
            ->call('unarchive');

        Mail::assertNothingQueued();
    }

    /** @test */
    public function all_members_get_notified_when_the_board_is_unarchived()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create(['archived' => true]);
        $member = User::factory()->create();
        Membership::factory()->for($member)->for($board)->create(['role' => 'member']);

        Mail::assertNothingQueued();

        Livewire::test(Show::class, ['board' => $board])
            ->call('unarchive');

        Mail::assertQueued(BoardUnarchivedMail::class, function(BoardUnarchivedMail $mail) use ($member) {
            return $mail->hasTo($member->email);
        });
    }

    /** @test */
    public function board_viewers_dont_get_notified_when_the_board_is_unarchived()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create(['archived' => true]);
        $viewer = User::factory()->create();
        Membership::factory()->for($viewer)->for($board)->create(['role' => 'viewer']);

        Livewire::test(Show::class, ['board' => $board])
            ->call('unarchive');

        Mail::assertNothingQueued();
    }
}
