<?php

namespace App\Http\Livewire\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    /**
     * The user's name.
     *
     * @var string
     */
    public $name;

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
     * The user's password confirmation.
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
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8', 'confirmed']
    ];

    /**
     * Render the page.
     *
     * @return  \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('auth.register')
            ->layout('layouts.app', ['title' => 'Register']);
    }

    /**
     * Register the user.
     *
     * @return  \Illuminate\Http\RedirectResponse
     */
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

        return redirect()->to(RouteServiceProvider::HOME);
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
