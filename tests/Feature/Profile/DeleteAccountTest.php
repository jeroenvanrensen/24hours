<?php

namespace Tests\Feature\Profile;

use App\Http\Livewire\Profile\DeleteAccount;
use App\Models\Board;
use App\Models\Link;
use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

/** @group profile */
class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_their_account()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertTrue($user->exists());

        Livewire::test(DeleteAccount::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('destroy')
            ->assertRedirect(route('login'));

        $this->assertFalse($user->exists());
    }

    /** @test */
    public function a_user_cant_delete_their_account_with_the_wrong_email()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(DeleteAccount::class)
            ->set('email', 'wrong-email')
            ->set('password', 'password')
            ->call('destroy')
            ->assertHasErrors('email')
            ->assertSet('password', '');

        $this->assertTrue($user->exists());
    }

    /** @test */
    public function a_user_cant_delete_their_account_with_the_wrong_password()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        Livewire::test(DeleteAccount::class)
            ->set('email', $user->email)
            ->set('password', 'wrong-password')
            ->call('destroy')
            ->assertHasErrors('email')
            ->assertSet('password', '');

        $this->assertTrue($user->exists());
    }

    /** @test */
    public function all_users_boards_are_deleted_when_they_delete_their_account()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();

        $this->assertTrue($board->exists());

        Livewire::test(DeleteAccount::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('destroy');

        $this->assertFalse($board->exists());
    }

    /** @test */
    public function all_users_links_are_deleted_when_they_delete_their_account()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $link = Link::factory()->for($board)->create();

        $this->assertTrue($link->exists());

        Livewire::test(DeleteAccount::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('destroy');

        $this->assertFalse($link->exists());
    }

    /** @test */
    public function all_users_notes_are_deleted_when_they_delete_their_account()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);

        $board = Board::factory()->for($user)->create();
        $note = Note::factory()->for($board)->create();

        $this->assertTrue($note->exists());

        Livewire::test(DeleteAccount::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('destroy');

        $this->assertFalse($note->exists());
    }
}
