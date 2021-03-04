<?php

namespace App\Http\Livewire\Auth;

use App\Models\Board;
use App\Models\Note;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $name;

    public $email;

    public $password;

    public $password_confirmation;

    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed']
    ];

    public function render()
    {
        return view('auth.register')
            ->layout('layouts.app');
    }

    public function updated($attribute)
    {
        if($attribute == 'password') {
            return;
        }
        
        $this->validateOnly($attribute);
    }

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password)
        ]);

        auth()->login($user);

        event(new Registered($user));

        $this->createInitialItems($user);

        return redirect()->to(route('invitations.check'));
    }

    protected function createInitialItems(User $user): void
    {
        $board = Board::create([
            'user_id' => $user->id,
            'name' => 'Welcome'
        ]);

        Note::create([
            'board_id' => $board->id,
            'title' => 'About 24Hours',
            'body' => '<h1>About 24Hours</h1><p>Hello ' . $user->first_name . '!</p><p><br></p><p>On this note, I would like to tell you a bit more about 24Hours. How it works and when you should use it.</p><p><br></p><p><strong>I recommend keeping this note as it explains the core features of 24Hours.</strong></p><p><br></p><h2>Boards, notes, and links</h2><p>Think of a <strong>board </strong>as a space to organize a project. For example, if you\'re creating a new website there is a lot to be done, and you can create a board to save everything.</p><h3><br></h3><p><strong>Notes </strong>are... notes! You can add as many notes as you would like. You can use them to write whole essays or to quickly clean your head. <strong>Notes are auto-saved</strong>, so all your edits will be saved immediately.</p><h3><br></h3><p>If you found something on the internet that you want to save for later, you can save them as a <strong>link</strong>. 24Hours will automatically get the title and an image so you can quickly and easily see which link is what page.</p><p><br></p><h2>Search</h2><p>Using 24Hours powerful search feature you can find everything that you\'ve lost! Head over to the search page and go searching!</p><p><br></p><h2>Collaboration</h2><p>Working together is very easy using 24Hours\' collaboration feature. You can invite anyone, also people who don\'t have an account yet.</p><p><br></p><p>In a board there are three roles with their own permissions:</p><p><br></p><p><strong>Owner</strong>: this is the creator of the board. Only the owner can edit or delete the board and can invite (and remove) members and viewers.</p><p><br></p><p><strong>Member</strong>: a member can create, edit and delete notes and add and remove links. The member can <strong>not</strong> edit the board itself or invite other members and viewers.</p><p><br></p><p><strong>Viewer</strong>: a viewer can only view notes and links. They cannot edit anything.</p><p><br></p><h2>Support</h2><p>If you have any questions, feature requests, or anything else, please contact me at <a href="https://www.jeroenvanrensen.nl/contact" target="_blank">https://www.jeroenvanrensen.nl/contact</a>.</p><p><br></p><p>Thanks for using 24Hours,</p><p>Jeroen van Rensen</p><p><em>Creator of 24Hours</em></p>'
        ]);
    }
}
