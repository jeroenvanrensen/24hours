<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    /**
     * The user's old password.
     *
     * @var string
     */
    public $old_password;

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
     * Render the component.
     *
     * @return  \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('profile.password');
    }

    /**
     * Update the user's password.
     *
     * @return  void
     */
    public function update()
    {
        if (!$this->oldPasswordIsCorrect()) {
            return $this->addError('old_password', 'The provided password does not match your current password.');
        }

        $this->validate();

        auth()->user()->update([
            'password' => Hash::make($this->password)
        ]);

        session()->flash('success', 'Saved.');
        $this->reset();
    }

    /**
     * Return whether the user's old password is correct.
     *
     * @return  bool
     */
    protected function oldPasswordIsCorrect()
    {
        return Hash::check($this->old_password, auth()->user()->password);
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
