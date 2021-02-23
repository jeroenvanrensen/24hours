<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;

class VerifyEmail extends Component
{
    public function render()
    {
        return view('auth.verify-email')
            ->layout('layouts.app', ['title' => 'Verify Email']);
    }

    public function request()
    {
        auth()->user()->sendEmailVerificationNotification();

        session()->flash('success', 'A new verification link has been sent to you!');
    }
}
