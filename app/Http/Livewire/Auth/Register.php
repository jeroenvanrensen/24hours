<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
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
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    public function render()
    {
        return view('auth.register');
    }

    public function updated($attribute)
    {
        if ($attribute === 'password') {
            return;
        }

        $this->validateOnly($attribute);
    }

    public function register()
    {
        $user = User::create([
            'password' => Hash::make($this->password),
        ] + $this->validate());

        auth()->login($user);

        event(new Registered($user));

        return redirect()->to(route('invitations.check'));
    }
}
