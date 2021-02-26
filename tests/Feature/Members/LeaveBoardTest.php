<?php

namespace Tests\Feature\Members;

use App\Http\Livewire\Members\Index;
use App\Mail\BoardLeftMail;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/** @group members */
class LeaveBoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_board_owner_cannot_leave_a_board()
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        Livewire::test(Index::class, ['board' => $board])
            ->call('leave')
            ->assertStatus(403);
    }

    /** @test */
    public function a_member_can_leave_a_board()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        $this->assertTrue($membership->exists());

        Livewire::test(Index::class, ['board' => $board])
            ->call('leave')
            ->assertRedirect(route('boards.index'));
        
        $this->assertFalse($membership->exists());
    }

    /** @test */
    public function a_viewer_can_leave_a_board()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        $membership = Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        $this->assertTrue($membership->exists());

        Livewire::test(Index::class, ['board' => $board])
            ->call('leave')
            ->assertRedirect(route('boards.index'));
        
        $this->assertFalse($membership->exists());
    }

    /** @test */
    public function users_will_get_an_email_when_someone_leaves_a_board()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $boardOwner = User::factory()->create();
        $alreadyMember = User::factory()->create();
        $board = Board::factory()->for($boardOwner)->create();
        $membership = Membership::factory()->for($alreadyMember)->for($board)->create();
        $membership = Membership::factory()->for($user)->for($board)->create();

        Mail::assertNothingQueued();

        Livewire::test(Index::class, ['board' => $board])
            ->call('leave')
            ->assertRedirect(route('boards.index'));

        // The board owner will get an email when someone leaves a board
        Mail::assertQueued(BoardLeftMail::class, function(BoardLeftMail $mail) use ($boardOwner) {
            return $mail->hasTo($boardOwner->email);
        });

        // All members will get an email when someone leaves a board
        Mail::assertQueued(BoardLeftMail::class, function(BoardLeftMail $mail) use ($alreadyMember) {
            return $mail->hasTo($alreadyMember->email);
        });

        // The leaving member won't get an email when he leaves a board
        Mail::assertNotQueued(BoardLeftMail::class, function(BoardLeftMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }
}
