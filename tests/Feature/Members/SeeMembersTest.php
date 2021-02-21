<?php

namespace Tests\Feature\Members;

use App\Http\Livewire\Members\Index;
use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SeeMembersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_members_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->get(route('members.index', $board))
            ->assertStatus(200)
            ->assertSeeLivewire('members.index')
            ->assertSeeLivewire('members.create');
    }

    /** @test */
    public function guests_cannot_visit_the_members_page()
    {
        $board = Board::factory()->create();

        $this->get(route('members.index', $board))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function non_owners_cannot_visit_the_members_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->create();

        $this->get(route('members.index', $board))
            ->assertStatus(403);
    }

    /** @test */
    public function all_members_are_shown_on_the_index_page()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $member = Membership::factory()->for($otherUser)->for($board)->create(['role' => 'member']);
        
        Livewire::test(Index::class, ['board' => $board])
            ->assertSee($user->name)
            ->assertSee('Owner')
            ->assertSee($member->name)
            ->assertSee('Member');
    }
}
