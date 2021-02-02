<?php

namespace App\Http\Livewire\Profile;

use Livewire\Component;

class ProfileInfo extends Component
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
     * Set the initial values.
     *
     * @return  void
     */
    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->email = auth()->user()->email;
    }

    /**
     * Render the component.
     *
     * @return  \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('profile.profile-info');
    }

    /**
     * Update the user's account.
     *
     * @return  void
     */
    public function update()
    {
        $attributes = $this->validate();

        if($this->emailChanged()) {
            $attributes['email_verified_at'] = null;
        }

        auth()->user()->update($attributes);

        session()->flash('success', 'Saved.');
    }

    /**
     * Determine whether the email has changed.
     *
     * @return  bool
     */
    protected function emailChanged()
    {
        return $this->email != auth()->user()->email;
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

    /**
     * Return the validation rules.
     *
     * @return  array
     */
    protected function getRules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . auth()->id()]
        ];
    }
}
