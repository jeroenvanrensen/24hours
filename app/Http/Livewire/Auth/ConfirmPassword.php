<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ConfirmPassword extends Component
{
    /**
     * The user's password.
     *
     * @var string
     */
    public $password = 'password';

    /**
     * Render the page.
     *
     * @return  \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('auth.confirm-password')
            ->layout('layouts.app', ['title' => 'Confirm Password']);
    }

    /**
     * Confirm the user's password.
     *
     * @return  \Illuminate\Http\RedirectResponse|void
     */
    public function confirm()
    {
        if (!$this->passwordIsCorrect()) {
            return $this->addError('password', 'The provided password is incorrect.');
        }

        session()->passwordConfirmed();

        return redirect()->intended();
    }

    /**
     * Check if the password is correct.
     *
     * @return  bool
     */
    protected function passwordIsCorrect()
    {
        return Hash::check($this->password, auth()->user()->password);
    }
}
