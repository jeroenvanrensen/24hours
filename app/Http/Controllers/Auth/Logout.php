<?php

namespace App\Http\Controllers\Auth;

class Logout
{
    public function __invoke()
    {
        auth()->logout();

        request()->session()->invalidate();

        request()->session()->regenerateToken();

        return redirect()->route('home');
    }
}
