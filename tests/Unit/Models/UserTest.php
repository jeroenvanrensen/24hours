<?php

namespace Tests\Unit\Models;

use App\Models\Board;
use App\Models\Invitation;
use App\Models\Link;
use App\Models\Membership;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_name()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create([
            'name' => 'John Doe'
        ]);

        $this->assertEquals('John Doe', $user->name);
    }

    /** @test */
    public function a_user_has_a_unique_email()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create([
            'email' => 'john@example.org'
        ]);

        $this->assertEquals('john@example.org', $user->email);

        $this->expectException(QueryException::class);
        
        User::factory()->create([
            'email' => 'john@example.org' // same email
        ]);
    }

    /** @test */
    public function a_user_has_a_nullable_email_verified_at_column()
    {
        $this->withoutExceptionHandling();

        $today = today();
        
        $user = User::factory()->create([
            'email_verified_at' => $today
        ]);

        $this->assertEquals($today, $user->email_verified_at);
        
        $user = User::factory()->create([
            'email_verified_at' => null
        ]);

        $this->assertNull($user->email_verified_at);
    }

    /** @test */
    public function a_user_has_a_password()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create([
            'password' => 'password'
        ]);

        $this->assertEquals('password', $user->password);
    }

    /** @test */
    public function a_user_has_a_nullable_remember_token_column()
    {
        $this->withoutExceptionHandling();

        $today = today();
        
        $user = User::factory()->create([
            'remember_token' => $today
        ]);

        $this->assertEquals($today, $user->remember_token);
        
        $user = User::factory()->create([
            'remember_token' => null
        ]);

        $this->assertNull($user->remember_token);
    }

    /** 
     * @test
     * @dataProvider namesProvider
     */
    public function a_user_has_a_first_name($fullName, $firstName)
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create(['name' => $fullName]);

        $this->assertEquals($firstName, $user->first_name);
    }

    public function namesProvider()
    {
        return [
            ['John', 'John'],
            ['John Doe', 'John'],
            ['Sylvia G. Smith', 'Sylvia'],
            ['Jeroen van Rensen', 'Jeroen']
        ];
    }

    /** @test */
    public function a_user_has_many_boards()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $board = Board::factory()->for($user)->create();

        $this->assertCount(1, $user->boards);
        $this->assertInstanceOf(Board::class, $user->boards[0]);
        $this->assertEquals($board->id, $user->boards[0]->id);
    }

    /** @test */
    public function a_user_has_many_links()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $board = Board::factory()->for($user)->create();

        $link = Link::factory()->for($board)->create();

        $this->assertCount(1, $user->links);
        $this->assertInstanceOf(Link::class, $user->links[0]);
        $this->assertEquals($link->id, $user->links[0]->id);
    }

    /** @test */
    public function a_user_has_many_notes()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $board = Board::factory()->for($user)->create();

        $note = Note::factory()->for($board)->create();

        $this->assertCount(1, $user->notes);
        $this->assertInstanceOf(Note::class, $user->notes[0]);
        $this->assertEquals($note->id, $user->notes[0]->id);
    }

    /** @test */
    public function a_user_has_many_memberships()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $membership = Membership::factory()->for($user)->create();

        $this->assertCount(1, $user->memberships);
        $this->assertInstanceOf(Membership::class, $user->memberships[0]);
        $this->assertEquals($membership->id, $user->memberships[0]->id);
    }

    /** @test */
    public function a_user_has_visible_boards()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();

        $firstBoard = Board::factory()->for($user)->create(); // owner - visible
        $secondBoard = Board::factory()->create(); // member - visible
        $membership = Membership::factory()->for($user)->for($secondBoard)->create();
        $thirdBoard = Board::factory()->create(); // invited - not visible
        $invitation = Invitation::factory()->for($thirdBoard)->create(['email' => $user->email]);
        $fourthBoard = Board::factory()->create(); // nothing - not visible

        $this->assertCount(2, $user->visibleBoards());

        $this->assertEquals($firstBoard->id, $user->visibleBoards()[1]->id);
        $this->assertEquals($secondBoard->id, $user->visibleBoards()[0]->id);
    }
}
