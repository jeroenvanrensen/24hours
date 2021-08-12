<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    public $token;

    public $email;

    public $password;

    public $password_confirmation;

    protected $rules = [
        'password' => ['required', 'string', 'min:8', 'confirmed']
    ];

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request('email');
    }

    public function render()
    {
        return view('auth.reset-password');
    }

    public function update()
    {
        $this->validate();

        $status = Password::reset(
            ['email' => $this->email, 'password' => $this->password, 'password_confirmation' => $this->password_confirmation, 'token' => $this->token],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                $user->setRememberToken(Str::random(60));

                event(new PasswordReset($user));
            }
        );

        return $status == Password::PASSWORD_RESET
            ? $this->handleSuccess()
            : $this->addError('email', 'This password reset token is invalid.');
    }

    protected function handleSuccess()
    {
        session()->flash('flash.success', 'Your password has been reset!');
        return redirect()->route('login');
    }
}
