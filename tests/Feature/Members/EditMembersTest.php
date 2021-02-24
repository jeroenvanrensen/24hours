<?php

namespace Tests\Feature\Members;

use App\Http\Livewire\Members\Edit;
use App\Mail\MembershipUpdatedMail;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class EditMembersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_project_owner_can_visit_the_edit_membership_page()
    {
        $this->withoutExceptionHandling();
        
        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        $this->get(route('members.edit', [$board, $membership]))
            ->assertStatus(200)
            ->assertSeeLivewire('members.edit')
            ->assertSeeLivewire('members.delete');
    }

    /** @test */
    public function members_cannot_visit_the_edit_membership_page()
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        Membership::factory()->for($user)->for($board)->create(['role' => 'member']);

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        $this->get(route('members.edit', [$board, $membership]))
            ->assertStatus(403);
    }

    /** @test */
    public function viewers_cannot_visit_the_edit_membership_page()
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();
        Membership::factory()->for($user)->for($board)->create(['role' => 'viewer']);

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        $this->get(route('members.edit', [$board, $membership]))
            ->assertStatus(403);
    }

    /** @test */
    public function non_members_cannot_visit_the_edit_membership_page()
    {
        Mail::fake();

        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        $this->get(route('members.edit', [$board, $membership]))
            ->assertStatus(403);
    }

    /** @test */
    public function guests_cannot_visit_the_edit_membership_page()
    {
        Mail::fake();

        $board = Board::factory()->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();

        $this->get(route('members.edit', [$board, $membership]))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function the_owner_can_edit_a_membership()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create(['role' => 'member']);

        $this->assertNotEquals('viewer', $membership->fresh()->role);
        
        Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
            ->set('role', 'viewer')
            ->call('update')
            ->assertRedirect(route('members.index', $board));

        $this->assertEquals('viewer', $membership->fresh()->role);
    }

    /** @test */
    public function a_membership_requires_a_valid_role()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create();
        
        Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
            ->set('role', 'member')
            ->call('update')
            ->assertHasNoErrors();
        
        Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
            ->set('role', 'viewer')
            ->call('update')
            ->assertHasNoErrors();
        
        Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
            ->set('role', 'invalid-role')
            ->call('update')
            ->assertHasErrors('role');
    }

    /** @test */
    public function the_member_gets_an_email_when_their_membership_is_changed()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create(['role' => 'member']);

        Mail::assertNothingQueued();
        
        Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
            ->set('role', 'viewer')
            ->call('update');

        Mail::assertQueued(MembershipUpdatedMail::class, function(MembershipUpdatedMail $mail) use ($member) {
            return $mail->hasTo($member->email);
        });
    }

    /** @test */
    public function the_member_does_not_get_an_email_when_their_membership_is_not_changed()
    {
        $this->withoutExceptionHandling();

        Mail::fake();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $member = User::factory()->create();
        $membership = Membership::factory()->for($member)->for($board)->create(['role' => 'member']);
        
        Livewire::test(Edit::class, ['board' => $board, 'membership' => $membership])
            ->set('role', 'member') // same role
            ->call('update');

        Mail::assertNothingQueued();
    }
}
