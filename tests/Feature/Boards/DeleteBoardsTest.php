<?php

namespace Tests\Feature\Boards;

use App\Http\Livewire\Boards\Edit;
use App\Mail\BoardDeletedMail;
use App\Models\Board;
use App\Models\Invitation;
use App\Models\Link;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteBoardsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_a_board()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->assertTrue($board->exists());

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        $this->assertFalse($board->exists());
    }

    /** @test */
    public function deleting_a_board_deletes_all_its_links_too()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $link = Link::factory()->for($board)->create();

        $this->assertTrue($link->exists());

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        $this->assertFalse($link->exists());
    }

    /** @test */
    public function deleting_a_board_deletes_all_its_notes_too()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertTrue($note->exists());

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        $this->assertFalse($note->exists());
    }

    /** @test */
    public function deleting_a_board_deletes_all_its_memberships_too()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $membership = Membership::factory()->for($board)->create();

        $this->assertTrue($membership->exists());

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        $this->assertFalse($membership->exists());
    }

    /** @test */
    public function every_member_will_get_an_email_when_a_board_is_deleted()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $otherUser = User::factory()->create();
        $board = Board::factory()->for($user)->create();
        $membership = Membership::factory()->for($board)->for($otherUser)->create();

        Mail::assertNothingQueued();

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        Mail::assertQueued(BoardDeletedMail::class, function(BoardDeletedMail $mail) use ($otherUser) {
            return $mail->hasTo($otherUser->email);
        });
    }

    /** @test */
    public function deleting_a_board_deletes_all_its_invitations_too()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $invitation = Invitation::factory()->for($board)->create();

        $this->assertTrue($invitation->exists());

        Livewire::test(Edit::class, ['board' => $board])
            ->call('destroy')
            ->assertRedirect(route('boards.index'));

        $this->assertFalse($invitation->exists());
    }
}
