<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** @group models */
class MembershipTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_membership_has_a_role()
    {
        $this->withoutExceptionHandling();
        
        $member = Membership::factory()->create([
            'role' => 'member'
        ]);

        $this->assertEquals('member', $member->role);
    }

    /** @test */
    public function a_membership_belongs_to_a_user()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $membership = Membership::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertEquals($user->id, $membership->user_id);

        $this->assertInstanceOf(User::class, $membership->user);
        $this->assertEquals($user->id, $membership->user->id);
    }

    /** @test */
    public function a_membership_belongs_to_a_board()
    {
        $this->withoutExceptionHandling();
        
        $board = Board::factory()->create();

        $membership = Membership::factory()->create([
            'board_id' => $board->id
        ]);

        $this->assertEquals($board->id, $membership->board_id);

        $this->assertInstanceOf(Board::class, $membership->board);
        $this->assertEquals($board->id, $membership->board->id);
    }
}
