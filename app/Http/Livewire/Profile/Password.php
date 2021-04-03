<?php

namespace App\Http\Livewire\Profile;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Password extends Component
{
    public $old_password;

    public $password;

    public $password_confirmation;

    protected $rules = [
        'password' => ['required', 'string', 'min:8', 'confirmed']
    ];

    public function render()
    {
        return view('profile.password');
    }

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

    protected function oldPasswordIsCorrect()
    {
        return Hash::check($this->old_password, auth()->user()->password);
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }
}
