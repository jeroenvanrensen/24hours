<?php

namespace App\Http\Livewire\Auth;

use App\Providers\RouteServiceProvider;
use Livewire\Component;

class Login extends Component
{
    /**
     * The user's email.
     *
     * @var string
     */
    public $email;

    /**
     * The user's password.
     *
     * @var string
     */
    public $password;

    /**
     * Whether to remember the user.
     *
     * @var bool
     */
    public $rememberMe;

    /**
     * Render the page.
     *
     * @return  \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('auth.login')
            ->layout('layouts.app', ['title' => 'Login']);
    }

    /**
     * Log the user in.
     *
     * @return  \Illuminate\Http\RedirectResponse|void
     */
    public function login()
    {
        $success = auth()->attempt(['email' => $this->email, 'password' => $this->password], $this->rememberMe);

        if ($success) {
            return redirect()->to(RouteServiceProvider::HOME);
        }

        $this->addError('email', 'These credentials do not match our records.');
        $this->reset('password');
    }
}
