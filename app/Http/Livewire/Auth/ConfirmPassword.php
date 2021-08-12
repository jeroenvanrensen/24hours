<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ConfirmPassword extends Component
{
    public $password = '';

    public function render()
    {
        return view('auth.confirm-password');
    }

    public function confirm()
    {
        if (!$this->passwordIsCorrect()) {
            return $this->addError('password', 'The provided password is incorrect.');
        }

        session()->passwordConfirmed();

        return redirect()->intended();
    }

    protected function passwordIsCorrect()
    {
        return Hash::check($this->password, auth()->user()->password);
    }
}
