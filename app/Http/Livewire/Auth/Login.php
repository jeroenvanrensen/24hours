<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Livewire\Component;

class Login extends Component
{
    public $email;

    public $password;

    public function render()
    {
        return view('auth.login')
            ->layout('layouts.app');
    }

    public function login()
    {
        $success = auth()->attempt(['email' => $this->email, 'password' => $this->password], true);

        if ($success) {
            return redirect()->to(route('invitations.check'));
        }

        $this->addError('email', 'These credentials do not match our records.');
        $this->reset('password');
    }
}
