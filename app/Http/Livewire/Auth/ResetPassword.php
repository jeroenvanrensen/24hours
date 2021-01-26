<?php

namespace App\Http\Livewire\Auth;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Component;

class ResetPassword extends Component
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The user's email.
     *
     * @var string
     */
    public $email;

    /**
     * The user's new password.
     *
     * @var string
     */
    public $password;

    /**
     * The user's new password confirmation.
     *
     * @var string
     */
    public $password_confirmation;

    /**
     * The validation rules.
     *
     * @var array
     */
    protected $rules = [
        'password' => ['required', 'string', 'min:8', 'confirmed']
    ];

    /**
     * Initialize the page.
     *
     * @param   string  $token
     * @return  void
     */
    public function mount($token)
    {
        $this->token = $token;
        $this->email = request('email');
    }

    /**
     * Render the page.
     *
     * @return  \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('auth.reset-password')
            ->layout('layouts.app', ['title' => 'Reset Password']);
    }

    /**
     * Update the user's password.
     *
     * @return  \Illuminate\Http\RedirectResponse|void
     */
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
            ? redirect()->route('login')
            : $this->addError('email', 'This password reset token is invalid.');
    }

    /**
     * Allow for real time validation.
     *
     * @param   string  $attribute
     * @return  void
     */
    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }
}
