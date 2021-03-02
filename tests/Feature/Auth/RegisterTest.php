<?php

namespace Tests\Feature\Auth;

use App\Http\Livewire\Auth\Register;
use App\Models\Board;
use App\Models\Note;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

/** @group auth */
class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_visit_the_register_page()
    {
        $this->withoutExceptionHandling();
        
        $this->get(route('register'))
            ->assertStatus(200)
            ->assertSeeLivewire('auth.register');
    }

    /** @test */
    public function authenticated_users_cannot_visit_the_register_page()
    {
        $this->withoutExceptionHandling();
        
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $this->get(route('register'))
            ->assertRedirect(RouteServiceProvider::HOME);
    }

    /** @test */
    public function a_user_can_register()
    {
        $this->withoutExceptionHandling();

        $this->assertCount(0, User::all());
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertRedirect(route('invitations.check'));

        $this->assertCount(1, User::all());

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.org'
        ]);
    }

    /** @test */
    public function a_user_is_authenticated_after_registering()
    {
        $this->withoutExceptionHandling();

        $this->assertFalse(auth()->check());
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register');

        $this->assertTrue(auth()->check());
    }

    /** @test */
    public function a_user_gets_an_email_verification_link_after_registering()
    {
        $this->withoutExceptionHandling();
        
        Notification::fake();

        Notification::assertNothingSent();
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register');

        Notification::assertSentTo(
            [User::first()], VerifyEmail::class
        );
    }

    /** @test */
    public function a_name_is_required()
    {
        $this->withoutExceptionHandling();
        
        Livewire::test(Register::class)
            ->set('name', null)
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors('name');
    }

    /** @test */
    public function a_valid_email_is_required()
    {
        $this->withoutExceptionHandling();
        
        // Empty email
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', null)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors('email');
        
        // Invalid email
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'invalid-email')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors('email');
    }

    /** @test */
    public function the_email_must_be_unique()
    {
        $this->withoutExceptionHandling();
        
        User::factory()->create(['email' => 'john@example.org']);

        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org') // email already exists
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertHasErrors('email');
    }

    /** @test */
    public function a_password_with_minimal_8_characters_is_required()
    {
        $this->withoutExceptionHandling();
        
        // Empty password
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', null)
            ->set('password_confirmation', null)
            ->call('register')
            ->assertHasErrors('password');
        
        // Too short password
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'short')
            ->set('password_confirmation', 'short')
            ->call('register')
            ->assertHasErrors('password');
    }

    /** @test */
    public function the_password_must_be_confirmed()
    {
        $this->withoutExceptionHandling();
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'other-password') // wrong confirmation
            ->call('register')
            ->assertHasErrors('password');
    }

    /** @test */
    public function after_registering_a_user_has_a_board()
    {
        $this->withoutExceptionHandling();
        
        $this->assertCount(0, Board::all());
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertRedirect(route('invitations.check'));

        $this->assertCount(1, Board::all());

        $this->assertDatabaseHas('boards', [
            'user_id' => User::first()->id,
            'name' => 'Welcome'
        ]);
    }

    /** @test */
    public function after_registering_a_user_has_a_note()
    {
        $this->withoutExceptionHandling();
        
        $this->assertCount(0, Note::all());
        
        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('email', 'john@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertRedirect(route('invitations.check'));

        $this->assertCount(1, Note::all());

        $this->assertDatabaseHas('notes', [
            'board_id' => Board::first()->id,
            'title' => 'About 24Hours',
            'body' => '<h1>About 24Hours</h1><p>Hello John!</p><p><br></p><p>On this note, I would like to tell you a bit more about 24Hours. How it works and when you should use it.</p><p><br></p><p><strong>I recommend keeping this note as it explains the core features of 24Hours.</strong></p><p><br></p><h2>Boards, notes, and links</h2><p>Think of a <strong>board </strong>as a space to organize a project. For example, if you\'re creating a new website there is a lot to be done, and you can create a board to save everything.</p><h3><br></h3><p><strong>Notes </strong>are... notes! You can add as many notes as you would like. You can use them to write whole essays or to quickly clean your head. <strong>Notes are auto-saved</strong>, so all your edits will be saved immediately.</p><h3><br></h3><p>If you found something on the internet that you want to save for later, you can save them as a <strong>link</strong>. 24Hours will automatically get the title and an image so you can quickly and easily see which link is what page.</p><p><br></p><h2>Search</h2><p>Using 24Hours powerful search feature you can find everything that you\'ve lost! Head over to the search page and go searching!</p><p><br></p><h2>Collaboration</h2><p>Working together is very easy using 24Hours\' collaboration feature. You can invite anyone, also people who don\'t have an account yet.</p><p><br></p><p>In a board there are three roles with their own permissions:</p><p><br></p><p><strong>Owner</strong>: this is the creator of the board. Only the owner can edit or delete the board and can invite (and remove) members and viewers.</p><p><br></p><p><strong>Member</strong>: a member can create, edit and delete notes and add and remove links. The member can <strong>not</strong> edit the board itself or invite other members and viewers.</p><p><br></p><p><strong>Viewer</strong>: a viewer can only view notes and links. They cannot edit anything.</p><p><br></p><h2>Support</h2><p>If you have any questions, feature requests, or anything else, please contact me at <a href="https://www.jeroenvanrensen.nl/contact" target="_blank">https://www.jeroenvanrensen.nl/contact</a>. </p><p><br></p><p>Thanks for using 24Hours,</p><p>Jeroen van Rensen</p>'
        ]);
    }

    /** @test */
    public function the_name_in_the_notes_salutation_is_correct()
    {
        $this->withoutExceptionHandling();
        
        $this->assertCount(0, Note::all());
        
        Livewire::test(Register::class)
            ->set('name', 'Jane Lastname')
            ->set('email', 'jane@example.org')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('register')
            ->assertRedirect(route('invitations.check'));

        $this->assertCount(1, Note::all());

        $this->assertDatabaseHas('notes', [
            'board_id' => Board::first()->id,
            'title' => 'About 24Hours',
            'body' => '<h1>About 24Hours</h1><p>Hello Jane!</p><p><br></p><p>On this note, I would like to tell you a bit more about 24Hours. How it works and when you should use it.</p><p><br></p><p><strong>I recommend keeping this note as it explains the core features of 24Hours.</strong></p><p><br></p><h2>Boards, notes, and links</h2><p>Think of a <strong>board </strong>as a space to organize a project. For example, if you\'re creating a new website there is a lot to be done, and you can create a board to save everything.</p><h3><br></h3><p><strong>Notes </strong>are... notes! You can add as many notes as you would like. You can use them to write whole essays or to quickly clean your head. <strong>Notes are auto-saved</strong>, so all your edits will be saved immediately.</p><h3><br></h3><p>If you found something on the internet that you want to save for later, you can save them as a <strong>link</strong>. 24Hours will automatically get the title and an image so you can quickly and easily see which link is what page.</p><p><br></p><h2>Search</h2><p>Using 24Hours powerful search feature you can find everything that you\'ve lost! Head over to the search page and go searching!</p><p><br></p><h2>Collaboration</h2><p>Working together is very easy using 24Hours\' collaboration feature. You can invite anyone, also people who don\'t have an account yet.</p><p><br></p><p>In a board there are three roles with their own permissions:</p><p><br></p><p><strong>Owner</strong>: this is the creator of the board. Only the owner can edit or delete the board and can invite (and remove) members and viewers.</p><p><br></p><p><strong>Member</strong>: a member can create, edit and delete notes and add and remove links. The member can <strong>not</strong> edit the board itself or invite other members and viewers.</p><p><br></p><p><strong>Viewer</strong>: a viewer can only view notes and links. They cannot edit anything.</p><p><br></p><h2>Support</h2><p>If you have any questions, feature requests, or anything else, please contact me at <a href="https://www.jeroenvanrensen.nl/contact" target="_blank">https://www.jeroenvanrensen.nl/contact</a>. </p><p><br></p><p>Thanks for using 24Hours,</p><p>Jeroen van Rensen</p>'
        ]);
    }
}
