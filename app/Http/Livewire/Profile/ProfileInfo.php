<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;

class ProfileInfo extends Component
{
    public $name;

    public $email;

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    public function render()
    {
        return view('profile.profile-info');
    }

    public function update()
    {
        $attributes = $this->validate();

        if ($this->emailChanged()) {
            $attributes['email_verified_at'] = null;
        }

        auth()->user()->update($attributes);

        session()->flash('success', 'Saved.');
    }

    protected function emailChanged()
    {
        return $this->email !== auth()->user()->email;
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    protected function getRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . auth()->id()]
        ];
    }
}
