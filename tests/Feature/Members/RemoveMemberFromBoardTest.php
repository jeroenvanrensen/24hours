<?php

namespace Tests\Feature\Members;

use App\Http\Livewire\Members\Delete;
use App\Mail\MemberRemovedMail;
use App\Mail\YouAreRemovedMail;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

/** @group members */
class RemoveMemberFromBoardTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_board_owner_can_remove_a_member()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        $this->assertTrue($membership->exists());

        Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
            ->call('destroy')
            ->assertRedirect(route('members.index', $board));

        $this->assertFalse($membership->exists());
    }

    /** @test */
    public function members_cannot_remove_a_member()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
            ->call('destroy')
            ->assertStatus(403);

        $this->assertTrue($membership->exists());
    }

    /** @test */
    public function viewers_cannot_remove_a_member()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
            ->call('destroy')
            ->assertStatus(403);

        $this->assertTrue($membership->exists());
    }

    /** @test */
    public function non_members_cannot_remove_a_member()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
            ->call('destroy')
            ->assertStatus(403);

        $this->assertTrue($membership->exists());
    }

    /** @test */
    public function guests_cannot_remove_a_member()
    {
        $board = Board::factory()->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
            ->call('destroy')
            ->assertStatus(403);

        $this->assertTrue($membership->exists());
    }

    /** @test */
    public function the_member_will_get_an_email_when_they_are_removed()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        Mail::assertNothingQueued();

        Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
            ->call('destroy')
            ->assertRedirect(route('members.index', $board));

        Mail::assertQueued(YouAreRemovedMail::class, function (YouAreRemovedMail $mail) use ($member) {
            return $mail->hasTo($member->email);
        });

        Mail::assertNotQueued(MemberRemovedMail::class);
    }

    /** @test */
    public function all_other_members_will_also_get_an_email_when_someone_is_removed()
    {
        $this->withoutExceptionHandling();

        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $oldMember = User::factory()->create();
        $oldMembership = Membership::factory()->for($oldMember)->for($board)->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        Mail::assertNothingQueued();

        Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
            ->call('destroy')
            ->assertRedirect(route('members.index', $board));

        Mail::assertQueued(MemberRemovedMail::class, function (MemberRemovedMail $mail) use ($oldMember) {
            return $mail->hasTo($oldMember->email);
        });

        Mail::assertNotQueued(YouAreRemovedMail::class, function (YouAreRemovedMail $mail) use ($oldMember) {
            return $mail->hasTo($oldMember->email);
        });
    }

    /** @test */
    public function a_board_owner_cannot_remove_a_member_when_the_board_is_archived()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create(['archived' => true]);

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        Livewire::test(Delete::class, ['board' => $board, 'membership' => $membership])
            ->call('destroy')
            ->assertStatus(403);

        $this->assertTrue($membership->exists());
    }
}
